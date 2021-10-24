<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller{

    protected $service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new UserService;
    }

    public function getUser()
    {
        $user = $this->service->getUserActive();
        return response()->json($user);
    }

    public function getUserDetail($code)
    {
        $userDetail = $this->service->getUserDetailByCode($code);

        return response()->json($userDetail);
    }

    public function deleteUser($code)
    {
        $deleteUser = $this->service->deleteUser($code);

        return response()->json($deleteUser);
    }

}