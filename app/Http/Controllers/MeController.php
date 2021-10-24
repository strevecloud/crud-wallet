<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use App\Service\UserWalletService;
use Illuminate\Http\Request;

class MeController extends Controller{

    protected $service,$userWalletService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new UserService;
        $this->userWalletService = new UserWalletService;
    }

    public function account(Request $request)
    {
        $user = $request->auth;
        $userDetail = $this->service->getUserByCode($user);

        return response()->json($userDetail);
    }

    public function getWallet(Request $request)
    {
        $user = $request->auth;
        $wallet = $this->userWalletService->getAllWallet($user);

        return response()->json($wallet);
    }

    public function createNewWallet(Request $request)
    {
        $user = $request->auth;

        $createWallet = $this->userWalletService->createNewWallet($user);

        return response()->json($createWallet);
    }

    public function topUp(Request $request,$walletCode)
    {
        $user = $request->auth;

        $dataRequest = [
            'user' => $user,
            'code' => $walletCode,
            'amount' => $request->input('amount')
        ];

        $createWallet = $this->userWalletService->topUp($dataRequest);
        
        return response()->json($createWallet);
    }

}