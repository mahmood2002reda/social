<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return response()->json($user->profile);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image',
        ]);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profile'), $imageName);
            $data['profile_picture'] = 'images/profile/' . $imageName;
        }

        $user->profile()->update($data);

        return response()->json(['message' => 'Profile updated', 'profile' => $user->profile]);
    }
}
