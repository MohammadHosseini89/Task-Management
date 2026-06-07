<?php

namespace App\Http\Livewire;

use App\Models\TagsForRaisedby;
use Livewire\Component;

class TagsForRaisedbyControlComponent extends Component
{
    public $raisedby_edit_id, $raisedby_delete_id, $raisedby_tags;

    public $view_raisedby_tags;

    public $searchTerm;

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'raisedby_tags' => 'required|string',

        ]);
    }

    public function storeRaisedbyData()
    {

        //on form submit validation
        $this->validate([
            'raisedby_tags' => 'required|string',
        ]);


        //Add Raisedby_Tags Data
        $raisedby_new = new TagsForRaisedby();
        $raisedby_new->raisedby_tags = $this->raisedby_tags;



        $create_raisedby = [
            'raisedby_tags' => $raisedby_new['raisedby_tags'],
        ];



        $raisedby_new->create($create_raisedby);

        session()->flash('message', 'New Raisedby has been added successfully');


        $this->raisedby_tags = '';


        //For hide modal after add success
        $this->dispatchBrowserEvent('close-modal-edit');
    }

    public function resetInputs()
    {
        $this->raisedby_tags = '';
    }


    public function close()
    {
        $this->closeModalDelete();
        $this->closeModalEdit();
        $this->closeModalAdd();
        $this->closeModalView();
    }

    public function editRaisedby($id)
    {
        $edit_raisedby = TagsForRaisedby::where('id', $id)->first();


        $this->raisedby_edit_id = $edit_raisedby->id;
        $this->raisedby_tags = $edit_raisedby->raisedby_tags;
        $this->dispatchBrowserEvent('show-edit-raisedby-modal');
    }

    public function editRaisedbyData()
    {
        //on form submit validation
        $this->validate([
            'raisedby_tags' => 'required|string',
        ]);


        $edit_raisedby = TagsForRaisedby::where('id', $this->raisedby_edit_id)->first();
        $edit_raisedby->raisedby_tags = $this->raisedby_tags;

        $update_raisedby = [
            'id' => $edit_raisedby->id,
            'raisedby_tags' => $this->raisedby_tags,
        ];

        $edit_raisedby->update($update_raisedby);

        session()->flash('message', 'RaisedBy has been updated successfully');


        //For hide modal after add success
        $this->close('close-modal');
    }


    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->raisedby_delete_id = $id;


        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }


    public function deleteRaisedByData()
    {
        $raisedby = TagsForRaisedby::where('id', $this->raisedby_delete_id)->first();
        $raisedby->delete();


        session()->flash('message', 'RaisedBy has been deleted successfully');


        $this->dispatchBrowserEvent('close-modal-delete');


        $this->raisedby_delete_id = '';
    }


    public function cancel()
    {
        $this->raisedby_delete_id = '';
    }


    public function viewRaisedbyDetails($id)
    {
        $raisedby_view = TagsForRaisedby::where('id', $id)->first();
        $this->view_raisedby_tags = $raisedby_view->id;


        $this->dispatchBrowserEvent('show-view-raisedby-modal');
    }


    public function closeViewRaisedbyModal()
    {
        $this->dispatchBrowserEvent('close-modal-view');
    }



    public function render()
    {
        //Get all Raisedby
        $Raisedby = TagsForRaisedby::where('raisedby_tags', 'like', '%' . $this->searchTerm . '%')
            ->get();
        return view('livewire.tags-for-raisedby-control-component', ['Raisedby' => $Raisedby]);
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
}
