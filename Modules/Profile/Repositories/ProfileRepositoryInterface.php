<?php
namespace Modules\Profile\Repositories;

use Modules\Profile\Entities\User;


interface ProfileRepositoryInterface
{
    public function createProfile(User $user, array $data);
    public function updateProfile(User $user, array $data);
    public function getProfile(User $user);
}