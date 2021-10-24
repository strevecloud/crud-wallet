<?php

namespace App\Http\Controllers;

use App\Service\UserWalletCardService;
use App\Service\UserWalletService;
use Illuminate\Http\Request;

class UserWalletCardController extends Controller{

    protected $user,$service,$userWalletCardService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = request()->auth;
        $this->service = new UserWalletService;
        $this->userWalletCardService = new UserWalletCardService;
    }

    public function getUserAllCard(Request $request,$walletCode)
    {
        $card = $this->userWalletCardService->getAllWalletCard($walletCode);
        return response()->json($card);
    }

    public function createNewCard(Request $request,$walletCode)
    {
        $user = $this->user;
        $createCard = $this->userWalletCardService->createNewWalletCard($user,$walletCode);
        return response()->json($createCard);
    }

    public function updateCard(Request $request,$cardCode)
    {
        $user = $this->user;

        $dataRequest = [
            'user' => $user,
            'code' => $cardCode,
            'daily_limit' => $request->input('daily_limit'),
            'monthly_limit' => $request->input('monthly_limit')
        ];

        $updateCard = $this->userWalletCardService->updateCard($dataRequest);

        return response()->json($updateCard);
    }

    public function deleteCard(Request $request,$cardCode)
    {
        $user = $this->user;

        $dataRequest=[
            'user' => $user,
            'code' => $cardCode
        ];
        return $this->userWalletCardService->deleteCard($dataRequest);
    }

}