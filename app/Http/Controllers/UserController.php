<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        // Validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // expects password_confirmation
            'is_admin' => ['nullable', 'in:0,1'],
        ]);

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->input('is_admin', 0), // default 0
        ]);

        return redirect()->route('users.create')->with('success', 'User berhasil dibuat.');
    }
}
