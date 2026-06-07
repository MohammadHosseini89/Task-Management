<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\MyTeams;
use App\Models\TagsForRaisedby;
use Livewire\Component;

class AssignCredentialsComponent extends Component
{
    public $myteams_edit_id, $myteams_delete_id, $team_name;
    public $position_name, $raisedby_access;

    public $view_team_name;
    public $view_position_name, $view_raisedby_access;

    public $searchTerm;
    public $raisedby_access_edit;

    public $searchTermFirstRaisedbyEdit;
    public $selectedItems_edit = [];

    public $stringraisedbyaccess_edit;

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'team_name' => 'required|string',
            'position_name' => 'required|string',
            'raisedby_access' => 'nullable|string',

        ]);
    }

    public function storeMyTeamsData()
    {

        //on form submit validation
        $this->validate([
            'team_name' => 'required|string',
            'position_name' => 'required|string',
            'raisedby_access' => 'nullable|string',
        ]);


        //Add Myteams Data
        $myteams_new = new MyTeams();
        $myteams_new->team_name = $this->team_name;
        $myteams_new->position_name = $this->position_name;
        $myteams_new->raisedby_access = $this->raisedby_access;


        $create_myteams = [
            'team_name' => $myteams_new['team_name'],
            'position_name' => $myteams_new['position_name'],
            'raisedby_access' => $myteams_new['raisedby_access'],
        ];



        $myteams_new->create($create_myteams);

        session()->flash('message', 'New Credentials has been added successfully');


        $this->team_name = '';
        $this->position_name = '';
        $this->raisedby_access = '';


        //For hide modal after add success
        $this->dispatchBrowserEvent('close-modal-edit');
    }

    public function resetInputs()
    {
        $this->team_name = '';
        $this->position_name = '';
        $this->raisedby_access = '';
    }


    public function close()
    {
        $this->closeModalDelete();
        $this->closeModalEdit();
        $this->closeModalAdd();
        $this->closeModalView();
    }

    public function editeMyTeams($id)
    {
        $edit_myteams = MyTeams::where('id', $id)->first();


        $this->myteams_edit_id = $edit_myteams->id;
        $this->team_name = $edit_myteams->team_name;
        $this->position_name = $edit_myteams->position_name;
        $this->raisedby_access = $edit_myteams->raisedby_access;

        $this->dispatchBrowserEvent('show-edit-myteams-modal');
    }

    public function editMyTeamsData()
    {
        if (strlen($this->stringraisedbyaccess_edit) >= 1) {
            $this->raisedby_access = $this->stringraisedbyaccess_edit;
        }
        //on form submit validation
        $this->validate([
            'team_name' => 'required|string',
            'position_name' => 'required|string',
            'raisedby_access' => 'nullable|string',
        ]);


        $edit_myteams = MyTeams::where('id', $this->myteams_edit_id)->first();
        $edit_myteams->team_name = $this->team_name;
        $edit_myteams->position_name = $this->position_name;
        $edit_myteams->raisedby_access = $this->raisedby_access;

        $update_myteams = [
            'id' => $edit_myteams->id,
            'team_name' => $this->team_name,
            'position_name' => $this->position_name,
            'raisedby_access' => $this->raisedby_access,
        ];

        $edit_myteams->update($update_myteams);

        session()->flash('message', 'Credentials has been updated successfully');


        //For hide modal after add success
        $this->close('close-modal');
    }


    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->myteams_delete_id = $id;


        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }


    public function deleteMyTeamsData()
    {
        $raisedby = MyTeams::where('id', $this->myteams_delete_id)->first();
        $raisedby->delete();


        session()->flash('message', 'Credentials has been deleted successfully');


        $this->dispatchBrowserEvent('close-modal-delete');


        $this->myteams_delete_id = '';
    }


    public function cancel()
    {
        $this->myteams_delete_id = '';
    }


    public function viewMyTeamsDetails($id)
    {
        $myteams_view = MyTeams::where('id', $id)->first();
        $this->view_team_name = $myteams_view->team_name;
        $this->view_position_name = $myteams_view->position_name;
        $this->view_raisedby_access = $myteams_view->raisedby_access;

        $this->dispatchBrowserEvent('show-view-myteams-modal');
    }


    public function closeViewMyTeamsModal()
    {
        $this->dispatchBrowserEvent('close-modal-view');
    }



    public function render()
    {
        //Get all Raisedby
        $teams = MyTeams::where('team_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('position_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('raisedby_access', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('user_id', 'like', '%' . $this->searchTerm . '%')
            ->get();

        $users = User::where('email', 'like', '%' . $this->searchTerm . '%')
            ->get();

        if (strlen($this->searchTermFirstRaisedbyEdit) >= 1) {
            $this->raisedby_access_edit = TagsForRaisedby::whereRaw('lower(raisedby_tags) like ?', ['%' . strtolower($this->searchTermFirstRaisedbyEdit) . '%'])
                ->get();
        }

        return view('livewire.assign-credentials-component', [
            'users' => $users,
            'teams' => $teams,
        ]);
    }


        // get Selected Raisedby Access
        public function getSelectedAccessRaisedByEdit()
        {
            $raisedbyaccessforedit = [];
    
            foreach ($this->selectedItems_edit as $selectedAccess) {
                $raisedbyaccessforedit[] = $selectedAccess;
            }
    
            $delimiter = ';';
            $this->stringraisedbyaccess_edit = implode($delimiter, array_values($raisedbyaccessforedit)) . $delimiter;
    
            // Clear the selected items array
            $this->selectedItems_edit = [];
    
            $this->dispatchBrowserEvent('close-view-raisedbyaccess-edit-search-modal');

        }

    public function closeModalView()
    {
        $this->dispatchBrowserEvent('close-modal-view');
    }
    public function closeModalEdit()
    {
        $this->dispatchBrowserEvent('close-modal-edit');
    }
    public function closeModalAdd()
    {
        $this->dispatchBrowserEvent('close-modal-add');
    }

    public function closeModalDelete()
    {
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function searchmodalraisedbyaccessopen()
    {
        $this->dispatchBrowserEvent('show-view-raisedbyaccess-edit-search-modal');
    }

    public function searchmodalraisedbyaccessclose()
    {
        $this->dispatchBrowserEvent('close-view-raisedbyaccess-edit-search-modal');
    }
}
