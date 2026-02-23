<?php
namespace Modules\Profile\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Profile\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $service) {}

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

        $this->service->createProfile(auth()->user(), $data, $request->file('profile_picture'));

        return redirect()->route('home')->with('status', 'Profile created successfully!');
    }

    public function show(User $user)
    {
        $profile = $this->service->getProfile($user);
        return view('profiles.show', compact('user', 'profile'));
    }

    public function edit(User $user)
    {
        $profile = $this->service->getProfile($user);
        return view('profiles.edit', compact('user', 'profile'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image',
        ]);

        $this->service->updateProfile($user, $data, $request->file('profile_picture'));

        return redirect()->route('profile.show', $user)
                         ->with('status', 'Profile updated successfully!');
    }
}