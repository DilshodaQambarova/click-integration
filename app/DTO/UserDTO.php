<?php

namespace App\DTO;

class UserDTO
{
    public string $name;
    public $phone;
    public $password;
    public function __construct($name, $phone, $password)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->password = $password;
    }
}
