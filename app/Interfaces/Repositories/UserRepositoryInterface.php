<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function createUser($data);
    public function getUserByPhone($phone);
}
