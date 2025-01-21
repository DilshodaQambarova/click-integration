<?php

namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserService extends BaseService implements UserServiceInterface
{

    public function __construct(protected UserRepository $userRepository)
    {
        //
    }
    public function registerUser($userDTO){
        $data = [
            'name' => $userDTO->name,
            'phone' => $userDTO->phone,
            'password' => bcrypt($userDTO->password),
        ];

        // dd($data);
        return $this->userRepository->createUser($data);
    }
    public function loginUser($data){
        $user = $this->userRepository->getUserByPhone($data['phone']);
        if(!$user || !Hash::check($data['password'], $user->password)){
            return $this->error(__('errors.user.not_found'), 404);
        }
        if($user->phone_verified_at == null){
            return $this->error(__('errors.phone.not_verified'), 403);
        }
        return $user->createToken('login')->plainTextToken;
    }
    public function verifyPhone($code){
        $this->userRepository->findUserByCode($code);
        return __('successes.phone.verified');
    }


}
