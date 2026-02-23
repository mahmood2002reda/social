<?php
namespace Modules\Profile\Repositories;

use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function createProfile(User $user, array $data)
    {
        return $user->profile()->create($data);
    }

    public function updateProfile(User $user, array $data)
    {
        return $user->profile->update($data);
    }

    public function getProfile(User $user)
    {
        return $user->profile;
    }
}