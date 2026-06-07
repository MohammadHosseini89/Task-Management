<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UsersControlComponent extends Component
{
    public $user_edit_id, $user_delete_id, $name, $email, $status, $is_superuser;
    public $route1, $route2, $route3, $route5, $route6, $route7, $route8;
    public $route9, $route10, $route11, $route12, $route13, $route14, $route15, $route16, $route17, $route18;
    public $password, $phone, $route4;

    public $view_user_name, $view_user_email, $view_user_status, $view_user_is_superuser;
    public $view_user_route1, $view_user_route2, $view_user_route3, $view_user_route5;
    public $view_user_route6, $view_user_route7, $view_user_route8, $view_user_route9;
    public $view_user_route10, $view_user_route11, $view_user_route12, $view_user_route13, $view_user_route14;
    public $view_user_route15, $view_user_route16, $view_user_route17, $view_user_route18, $view_user_password;
    public $view_user_id, $changePassword;
    public $view_user_phone, $view_user_route4;

    public $searchTerm;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';


    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'email' => 'required|string',
            'status' => 'required|string',
            'phone' => 'required|string',
            'is_superuser' => 'Boolean',
            'route1' => 'Boolean',
            'route2' => 'Boolean',
            'route3' => 'Boolean',
            'route4' => 'Boolean',
            'route5' => 'Boolean',
            'route6' => 'Boolean',
            'route7' => 'Boolean',
            'route8' => 'Boolean',
            'route9' => 'Boolean',
            'route10' => 'Boolean',
            'route11' => 'Boolean',
            'route12' => 'Boolean',
            'route13' => 'Boolean',
            'route14' => 'Boolean',
            'route15' => 'Boolean',
            'route16' => 'Boolean',
            'route17' => 'Boolean',
            'route18' => 'Boolean',
            'password' => 'required|string',

        ]);
    }

    public function storeUserData()
    {

        //on form submit validation
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'status' => 'required|string',
            'is_superuser' => 'Boolean',
            'route1' => 'Boolean',
            'route2' => 'Boolean',
            'route3' => 'Boolean',
            'route5' => 'Boolean',
            'route6' => 'Boolean',
            'route7' => 'Boolean',
            'route8' => 'Boolean',
            'route9' => 'Boolean',
            'route10' => 'Boolean',
            'route11' => 'Boolean',
            'route12' => 'Boolean',
            'route13' => 'Boolean',
            'route14' => 'Boolean',
            'route15' => 'Boolean',
            'route16' => 'Boolean',
            'route17' => 'Boolean',
            'route18' => 'Boolean',
            'password' => 'required|string',

        ]);


        //Add User Data
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->is_superuser = $this->is_superuser;
        $user->route1 = $this->route1;
        $user->route2 = $this->route2;
        $user->route3 = $this->route3;
        $user->route5 = $this->route5;
        $user->route6 = $this->route6;
        $user->route7 = $this->route7;
        $user->route8 = $this->route8;
        $user->route9= $this->route9;
        $user->route10= $this->route10;
        $user->route11= $this->route11;
        $user->route12= $this->route12;
        $user->route13= $this->route13;
        $user->route14= $this->route14;
        $user->route15= $this->route15;
        $user->route16= $this->route16;
        $user->route17= $this->route17;
        $user->route18= $this->route18;
        $user->password = $this->password;


        $password = $this->password;
        $hashedPassword = Hash::make($password);



        $create_user = [
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => $user['status'],
            'is_superuser' => $user['is_superuser'],
            'route1' => $user['route1'],
            'route2' => $user['route2'],
            'route3' => $user['route3'],
            'route5' => $user['route5'],
            'route6' => $user['route6'],
            'route7' => $user['route7'],
            'route8' => $user['route8'],
            'route9' => $user['route9'],
            'route10' => $user['route10'],
            'route11' => $user['route11'],
            'route12' => $user['route12'],
            'route13' => $user['route13'],
            'route14' => $user['route14'],
            'route15' => $user['route15'],
            'route16' => $user['route16'],
            'route17' => $user['route17'],
            'route18' => $user['route18'],
            'password' => $hashedPassword,

        ];



        // $user->save();
        $user->create($create_user);

        session()->flash('message', 'New User has been added successfully');


        $this->name = '';
        $this->email = '';
        $this->status = '';
        $this->is_superuser = '';
        $this->route1 = '';
        $this->route2 = '';
        $this->route3 = '';
        $this->route5 = '';
        $this->route6 = '';
        $this->route7 = '';
        $this->route8 = '';
        $this->route9= '';
        $this->route10= '';
        $this->route11= '';
        $this->route12= '';
        $this->route13= '';
        $this->route14= '';
        $this->route15= '';
        $this->route16= '';
        $this->route17= '';
        $this->route18= '';
        $this->password = '';


        //For hide modal after add User success
        $this->dispatchBrowserEvent('close-modal-edit');
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->email = '';
        $this->status = '';
        $this->is_superuser = '';
        $this->route1 = '';
        $this->route2 = '';
        $this->route3 = '';
        $this->route5 = '';
        $this->route6 = '';
        $this->route7 = '';
        $this->route8 = '';
        $this->route9= '';
        $this->route10= '';
        $this->route11= '';
        $this->route12= '';
        $this->route13= '';
        $this->route14= '';
        $this->route15= '';
        $this->route16= '';
        $this->route17= '';
        $this->route18= '';
        $this->password = '';
    }


    public function close()
    {
        $this->closeModalDelete();
        $this->closeModalEdit();
        $this->closeModalAdd();
        $this->closeModalView();
    }

    public function editUsers($id)
    {
        $user = User::where('id', $id)->first();


        $this->user_edit_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->status = $user->status;
        $this->is_superuser = $user->is_superuser;
        $this->route1 = $user->route1;
        $this->route2 = $user->route2;
        $this->route3 = $user->route3;
        $this->route4 = $user->route4;
        $this->route5 = $user->route5;
        $this->route6 = $user->route6;
        $this->route7 = $user->route7;
        $this->route8 = $user->route8;
        $this->route9= $user->route9;
        $this->route10= $user->route10;
        $this->route11= $user->route11;
        $this->route12= $user->route12;
        $this->route13= $user->route13;
        $this->route14= $user->route14;
        $this->route15= $user->route15;
        $this->route16= $user->route16;
        $this->route17= $user->route17;
        $this->route18= $user->route18;
        $this->password = $user->password;



        $this->dispatchBrowserEvent('show-edit-user-modal');
    }

    public function editUserData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'status' => 'required|string',
            'is_superuser' => 'Boolean',
            'route1' => 'Boolean',
            'route2' => 'Boolean',
            'route3' => 'Boolean',
            'route4' => 'Boolean',
            'route5' => 'Boolean',
            'route6' => 'Boolean',
            'route7' => 'Boolean',
            'route8' => 'Boolean',
            'route9' => 'Boolean',
            'route10' => 'Boolean',
            'route11' => 'Boolean',
            'route12' => 'Boolean',
            'route13' => 'Boolean',
            'route14' => 'Boolean',
            'route15' => 'Boolean',
            'route16' => 'Boolean',
            'route17' => 'Boolean',
            'route18' => 'Boolean',
            'password' => 'required|string',
        ]);


        $user = User::where('id', $this->user_edit_id)->first();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->status = $this->status;
        $user->is_superuser = $this->is_superuser;
        $user->route1 = $this->route1;
        $user->route2 = $this->route2;
        $user->route3 = $this->route3;
        $user->route4 = $this->route4;
        $user->route5 = $this->route5;
        $user->route6 = $this->route6;
        $user->route7 = $this->route7;
        $user->route8 = $this->route8;
        $user->route9= $this->route9;
        $user->route10= $this->route10;
        $user->route11= $this->route11;
        $user->route12= $this->route12;
        $user->route13= $this->route13;
        $user->route14= $this->route14;
        $user->route15= $this->route15;
        $user->route16= $this->route16;
        $user->route17= $this->route17;
        $user->route18= $this->route18;
        $user->password = $this->password;

        $password = $this->password;
        $hashedPassword = Hash::make($password);

        $update_user = [
            'id' => $user->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'is_superuser' => $this->is_superuser,
            'route1' => $this->route1,
            'route2' => $this->route2,
            'route3' => $this->route3,
            'route4' => $this->route4,
            'route5' => $this->route5,
            'route6' => $this->route6,
            'route7' => $this->route7,
            'route8' => $this->route8,
            'route9' => $this->route9,
            'route10' => $this->route10,
            'route11' => $this->route11,
            'route12' => $this->route12,
            'route13' => $this->route13,
            'route14' => $this->route14,
            'route15' => $this->route15,
            'route16' => $this->route16,
            'route17' => $this->route17,
            'route18' => $this->route18,
        ];

        if ($this->changePassword) {
            $hashedPassword = Hash::make($this->password);
            $update_user['password'] = $hashedPassword;
        }

        $user->update($update_user);
        //   $user->save();


        session()->flash('message', 'User has been updated successfully');


        //For hide modal after add User success
        $this->close('close-modal');
    }


    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->user_delete_id = $id; //User id


        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }


    public function deleteUserData()
    {
        $user = User::where('id', $this->user_delete_id)->first();
        $user->delete();


        session()->flash('message', 'User has been deleted successfully');


        $this->dispatchBrowserEvent('close-modal-delete');


        $this->user_delete_id = '';
    }


    public function cancel()
    {
        $this->user_delete_id = '';
    }


    public function viewUserDetails($id)
    {
        $user = User::where('id', $id)->first();
        $this->view_user_id = $user->id;
        $this->view_user_name = $user->name;
        $this->view_user_email = $user->email;
        $this->view_user_phone = $user->phone;
        $this->view_user_status = $user->status;
        $this->view_user_is_superuser = $user->is_superuser;
        $this->view_user_route1 = $user->route1;
        $this->view_user_route2 = $user->route2;
        $this->view_user_route3 = $user->route3;
        $this->view_user_route4 = $user->route4;
        $this->view_user_route5 = $user->route5;
        $this->view_user_route6 = $user->route6;
        $this->view_user_route7 = $user->route7;
        $this->view_user_route8 = $user->route8;
        $this->view_user_route9= $user->route9;
        $this->view_user_route10= $user->route10;
        $this->view_user_route11= $user->route11;
        $this->view_user_route12= $user->route12;
        $this->view_user_route13= $user->route13;
        $this->view_user_route14= $user->route14;
        $this->view_user_route15= $user->route15;
        $this->view_user_route16= $user->route16;
        $this->view_user_route17= $user->route17;
        $this->view_user_route18= $user->route18;
        $this->view_user_password = $user->password;

        $this->dispatchBrowserEvent('show-view-user-modal');
    }


    public function closeViewUserModal()
    {
        $this->dispatchBrowserEvent('close-modal-view');
    }


    public function render()
    {
        //Get all Users
        $users = User::where('name', 'like', '%' . $this->searchTerm . '%')->orWhere('email', 'like', '%' . $this->searchTerm . '%')->orWhere('status', 'like', '%' . $this->searchTerm . '%')->orWhere('is_superuser', 'like', '%' . $this->searchTerm . '%')->orderBy($this->sortColumnName, $this->sortDirection)->get();
        return view('livewire.users-control-component', ['users' => $users]);
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'desc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return  $this->sortDirection === 'asc' ? 'desc' : 'asc';
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
