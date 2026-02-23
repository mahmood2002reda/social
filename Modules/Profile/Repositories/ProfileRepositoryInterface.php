<?php
namespace Modules\Profile\Repositories;

use App\Models\User;

interface ProfileRepositoryInterface
{
    public function createProfile(User $user, array $data);
    public function updateProfile(User $user, array $data);
    public function getProfile(User $user);
}