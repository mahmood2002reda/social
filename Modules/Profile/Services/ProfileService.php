<?php
namespace Modules\Profile\Services;

use Modules\Profile\Entities\User;
use Modules\Profile\Repositories\ProfileRepositoryInterface;

class ProfileService
{
    public function __construct(private ProfileRepositoryInterface $repo) {}

    public function createProfile(User $user, array $data, $file = null)
    {
        if ($file) {
            $data['profile_picture'] = $this->handleProfileImage($file);
        }

        return $this->repo->createProfile($user, $data);
    }

    public function updateProfile(User $user, array $data, $file = null)
    {
        if ($file) {
            if (optional($user->profile)->profile_picture && file_exists(public_path($user->profile->profile_picture))) {
                unlink(public_path($user->profile->profile_picture));
            }

            $data['profile_picture'] = $this->handleProfileImage($file);
        }

        return $this->repo->updateProfile($user, $data);
    }

    private function handleProfileImage($file): string
    {
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/profile'), $imageName);
        return 'images/profile/' . $imageName;
    }

    public function getProfile(User $user)
    {
        return $this->repo->getProfile($user);
    }
}