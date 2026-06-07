<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (session('error') == 'Your Account is Disabled') {
            // Get the current user's ID
            $userId = Auth::id();

            // Update the user's login history with the logout time
            LoginHistory::where('user_id', $userId)
                ->whereNull('logout_time')
                ->update(['logout_time' => now()]);
            // Logout the user
            return view('auth.login');
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
;

        } elseif (session('error') == 'You Need to login Again') {
            $userId = Auth::id();

            // Update the user's login history with the logout time
            LoginHistory::where('user_id', $userId)
                ->whereNull('logout_time')
                ->update(['logout_time' => now()]);
                return view('auth.login');
            // Logout the user
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();


        } elseif (!Auth::check()) {
            return view('auth.login');
        } elseif (Auth::check()) {
            return redirect('/welcome');
        } else {
            return view('auth.login');
        }
    }
}
