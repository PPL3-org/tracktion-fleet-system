<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 8 karakter.',
            'email.email' => 'Format email tidak valid. Pastikan format email sudah benar.'
        ]);

        $user =  User::create($attributes);

        Auth::login($user);
        
        return redirect()->route('shipments.index');
    }
}