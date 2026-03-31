<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordHistory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user = $request->user();

        $setting = Setting::first();
        $historyCount = $setting ? $setting->password_history_count : 3;

        $oldPasswords = PasswordHistory::where('user_id', $user->id)
            ->latest()
            ->take($historyCount)
            ->pluck('password');

        foreach ($oldPasswords as $oldPasswordHash) {
            if (Hash::check($request->password, $oldPasswordHash)) {
                return back()->withErrors([
                    'password' => "Nova lozinka ne sme biti ista kao poslednjih {$historyCount} lozinki."
                ], 'updatePassword');
            }
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Nova lozinka ne sme biti ista kao trenutna lozinka.'
            ], 'updatePassword');
        }

        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $user->password,
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}