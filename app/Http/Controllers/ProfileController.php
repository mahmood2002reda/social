<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'bio' => 'required|string|max:255',
        'profile_picture' => 'nullable|image',
    ]);

    $imageName = null;
    if ($request->hasFile('profile_picture')) {
        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/profile'), $imageName);
        
        $data['profile_picture'] = 'images/profile/' . $imageName;
    }

    auth()->user()->profile()->create($data);

    return redirect()->route('home')->with('status', 'Profile created successfully!');
}

    public function show(User $user) {
        return view('profiles.show', compact('user'));
    }

    public function edit(User $user) {
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
      //  dd($request->all());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image',
        ]);
    
        if ($request->hasFile('profile_picture')) {
           if (optional($user->profile)->profile_picture && file_exists(public_path($user->profile->profile_picture))) {
               unlink(public_path($user->profile->profile_picture));
}
    
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profile'), $imageName);
    
            $data['profile_picture'] = 'images/profile/' . $imageName;
        }
    
        $user->profile->update($data);
        
        return redirect()->route('profile.show', $user)->with('status', 'Profile updated successfully!');
    }
    
}
