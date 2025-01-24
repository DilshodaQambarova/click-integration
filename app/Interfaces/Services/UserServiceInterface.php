<?php

namespace App\Interfaces\Services;


interface UserServiceInterface
{
    public function registerUser($userDTO);
    public function loginUser($data);
    public function verifyPhone($data);
    public function sendSms($user);
}
