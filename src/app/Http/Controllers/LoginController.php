<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Userdata;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Userdata::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if($user->level=="admin")
            return redirect()->route('userdata.index')->with('success', 'Logged in successfully!');
        
            else if($user->level=="dokter")
            return redirect()->route('pemeriksaan.index')->with('success', 'Logged in successfully!');
        
            else if($user->level=="apoteker")
            return redirect()->route('resep.index')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
