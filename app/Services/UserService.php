<?php

namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
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
        if($user->phone_verified_at !== null){

            $token = $user->createToken('login')->plainTextToken;
            return $this->success($token, __('successes.user.logged'));
        }
        return $this->error(__('errors.phone.not_verified'), 403);    }
    public function verifyPhone($code){
        $this->userRepository->findUserByCode($code);
        return __('successes.phone.verified');
    }
    public function sendSms($phone){
        Cache::forget('verification_code');
        Cache::remember('verification_code', 60, function(){
            return rand(12345, 99999);
        });
        $verification_code = Cache::get('verification_code');
        Http::withHeaders([
            'Authorization' => 'Bearer ' . 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3Mzk5NjM1MTksImlhdCI6MTczNzM3MTUxOSwicm9sZSI6InVzZXIiLCJzaWduIjoiNDA4Yzg5YWNhODhhMDZkODJhZDEwMDZkNjUzMzMzYmM1YjIzNzI2MzU2ZTEzZmE0NGJkMjE1YWViZTNiNGQwOCIsInN1YiI6IjM2MTYifQ.5fDNRTc6DKd4DfMg7-Z7JJOEmqTsdbFupzydidcmGAk',
        ])->post('https://notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => $phone,
            'message'      => "Afisha Market MCHJ Tasdiqlovchi kodni kiriting:" . $verification_code,
            'from'         => '4546',
        ]);
    }


}
