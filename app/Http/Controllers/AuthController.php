<?php
namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Services\UserServiceInterface;
use App\Jobs\SendSmsJob;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected UserServiceInterface $userService)
    {

    }
    public function register(RegisterRequest $request)
    {

        $userDTO = new UserDTO($request->name, $request->phone, $request->password);
        $user    = $this->userService->registerUser($userDTO);
        SendSmsJob::dispatch($user);
        return $this->success(new UserResource($user), __('successes.user.created'), 201);
    }
    public function login(LoginRequest $request)
    {
        $token = $this->userService->loginUser($request->all());
        return $this->success($token, __('successes.user.logged'));
    }
    public function getUser(Request $request)
    {
        return $this->success(new UserResource($request->user()));
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success([], __('successes.user.logged_out'), 204);
    }
    public function verifyPhone(Request $request)
    {
        $message = $this->userService->verifyPhone($request->code);
        return $this->success([], $message);
    }
}
