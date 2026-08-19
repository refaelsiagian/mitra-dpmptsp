<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        return view('company.settings');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->user()->id),
            ],
            'current_password_for_email' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')->with('success', 'Email berhasil diperbarui. Silakan verifikasi alamat email baru Anda.');
        }

        return back()->with('info', 'Alamat email yang dimasukkan sama dengan saat ini.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
