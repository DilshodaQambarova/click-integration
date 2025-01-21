<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($data){
        $user = new User();
        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->verification_code = rand(12345, 99999);
        $user->save();
        return $user;
    }
    public function getUserByPhone($phone){
        return User::where('phone', $phone)->firstOrFail();
    }
    public function findUserByCode($code){
        $user = User::where('verification_code', $code)->firstOrFail();
        $user->phone_verified_at = now();
        $user->save();
        return $user;
    }
}
