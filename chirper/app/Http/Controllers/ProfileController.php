<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            //'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        /*if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }*/

        if ($request->hasFile('avatar')) {

            // Удаляем старый аватар, если он есть
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новый
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return back()->with('status', 'Profile updated!');
    }
}
