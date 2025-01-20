<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Support\Str;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($data){
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['phone'];
        $user->password = $data['password'];
        $user->save();
        return $user;
    }
    public function getUserByEmail($phone){
        return User::where('phone', $phone)->firstOrFail();
    }
    public function findUserByToken($token){
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->phone_verified_at = now();
        $user->save();
        return $user;
    }
}
