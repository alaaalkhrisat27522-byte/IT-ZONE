<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:190|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'role_id' => Role::firstOrCreate(['slug' => 'user'], ['name' => 'User', 'is_system' => true])->id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', '🎉 مرحباً بك في IT Zone!');
    }
}
