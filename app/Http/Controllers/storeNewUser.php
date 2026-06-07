<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class storeNewUser extends Controller
{
    public function store(Request $request){
        $validatedData = $request->validate([
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

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->is_superuser = $request->is_superuser;
        $user->route1 = $request->route1;
        $user->route2 = $request->route2;
        $user->route3 = $request->route3;
        $user->route4 = $request->route4;
        $user->route5 = $request->route5;
        $user->route6 = $request->route6;
        $user->route7 = $request->route7;
        $user->route8 = $request->route8;
        $user->route9 = $request->route9;
        $user->route10 = $request->route10;
        $user->route11 = $request->route11;
        $user->route12 = $request->route12;
        $user->route13 = $request->route13;
        $user->route14 = $request->route14;
        $user->route15 = $request->route15;
        $user->route16 = $request->route16;
        $user->route17 = $request->route17;
        $user->route18 = $request->route18;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/user-control-admin')->with('success', 'User added successfully.');
    }
}
