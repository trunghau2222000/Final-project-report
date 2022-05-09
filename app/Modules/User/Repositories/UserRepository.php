<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get User Current
     * @param $data
     * @return User
     */
    public function create($data)
    {
        return User::create($data);
    }
}
