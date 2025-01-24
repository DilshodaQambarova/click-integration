<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($data){
        $user = new User();
        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->verification_code = rand(10000, 99999);
        $user->save();
        return $user;
    }
    public function getUserByPhone($phone){
        return User::where('phone', $phone)->firstOrFail();
    }
    
}
