<?php
namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\UserWalletRepository;

class UserWalletService extends BaseService{

    protected $userRepository,$userWalletRepository;

    public function __construct()
    {
        $this->userWalletRepository = new UserWalletRepository;
        $this->userRepository = new UserRepository;

    }

    public function getUserActive()
    {
        return $this->userRepository->getUserActive();
    }

    public function getAllWallet($user)
    {
        $walletActive = $this->userWalletRepository
            ->getUserWalletActiveByUserCode($user->code);

        return $this->sendSuccess($walletActive);
    }

    public function createNewWallet($user)
    {
        $data = [
            'user_id' => $user->id
        ];

        $newWallet = $this->userWalletRepository->createNewUserWallet($data);

        if($newWallet){

            return $this->sendCreated($newWallet,'Success Create Wallet');
        }else{
            return $this->sendBadRequest('Create Wallet Failed');
        }
    }

    public function topUp($dataRequest)
    {
        $getWallet = $this->userWalletRepository->getUserWalletByCode($dataRequest['code']);

        if($getWallet->user_id != $dataRequest['user']->id){
            return $this->sendBadRequest('This is not your wallet');
        }

        $totalAmount = $dataRequest['amount']+$getWallet->amount;

        $data = [
            'amount' => $totalAmount
        ];

        $topUp = $this->userWalletRepository->updateUserWallet($dataRequest['code'],$data);

        if($topUp){
            return $this->sendSuccess($topUp,'Topup Success');
        }else{
            return $this->sendBadRequest('Topup Failed');
        }
    }

}