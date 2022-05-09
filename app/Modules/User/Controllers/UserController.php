<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\UserLoginRequest;
use App\Modules\User\Requests\UserRegisterRequest;
use App\Modules\User\Services\Interfaces\UserServiceInterface;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * User register
     * @param $request
     * @return reponse
     */
    public function register(UserRegisterRequest $request)
    {
        return $this->userService->register($request);

    }

    /**
     * User login
     * @param $request
     * @return reponse
     */
    public function login(UserLoginRequest $request)
    {
        return $this->userService->login($request);

    }

    /**
     * get Current User
     * @return reponse
     */
    public function getCurrentUser()
    {
        return $this->userService->getCurrentUser();
    }
}
