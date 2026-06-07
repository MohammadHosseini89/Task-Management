<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PasswordResetCheck;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function render()
    {

        $this->email = auth()->user()->email;
        return view('livewire.reset-password');
    }

    //Input fields on update validation
    public function updated($fields)
    {

        $this->validateOnly($fields, [
            'email' => 'required',
            'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be only number',
        ]);
    }

    public function resetpassword(Request $request)
    {

        $this->validate([
            'email' => 'required',
            // 'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be only number',
        ]);

        $user = User::where('email', '=', $this->email)->first();


        if (strlen($this->password) < 8) {
            session()->flash('error', 'Password Should Be at Least 8 Characters');
            return;
        }


        if (!preg_match('/[0-9]/', $this->password)) {
            session()->flash('error', ' Must Contain at Least One Number.');
            return;
        }

        if (!preg_match('/[A-Z]/', $this->password)) {
            session()->flash('error', ' Must Contain at Least One Uppercase Letter.');
            return;
        }

        if (!preg_match('/[a-z]/', $this->password)) {
            session()->flash('error', ' Must Contain at Least One Lowercase Letter.');
            return;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $this->password)) {
            session()->flash('error', ' Must Contain at Least One Special Character.');
            return;
        }



        if ($this->password !== $this->password_confirmation) {
            session()->flash('error', 'Password and Password Confirmation is Not Match');
            return;
        } else {
            $hashedPassword = Hash::make($this->password);
            $update_user['password'] = $hashedPassword;
            $user->update($update_user);

            $checkpasswordreset = PasswordResetCheck::where('email', '=', auth()->user()->email)->first();
            if (empty($checkpasswordreset)) {
                PasswordResetCheck::create([
                    'email' => auth()->user()->email,
                    'done_or_not' => 'Done',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $checkpasswordreset['updated_at'] = now();
                $checkpasswordreset->save();
            }

            session()->flash('message', 'Password has been updated successfully');
            return redirect('/welcome');
        }
    }
}
