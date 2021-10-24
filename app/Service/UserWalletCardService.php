<?php
namespace App\Service;

use App\Repository\UserWalletRepository;
use App\Repository\UserWalletCardRepository;
use Carbon\Carbon;

class UserWalletCardService extends BaseService{

    protected $userWalletCardRepository,$userWalletRepository;

    public function __construct()
    {
        $this->userWalletCardRepository = new UserWalletCardRepository;
        $this->userWalletRepository = new UserWalletRepository;

    }

    public function getUserWalletCardActive()
    {
        return $this->userWalletCardRepository->getUserWalletCardActive();
    }

    public function getAllWalletCard($code)
    {
        $cardActive = $this->userWalletCardRepository
            ->getUserWalletCardActiveByUserWalletCode($code);

        return $cardActive;
    }

    public function createNewWalletCard($user,$code)
    {
        $getWallet = $this->userWalletRepository->getUserWalletByCode($code);

        if($getWallet->user_id != $user->id){
            
            return $this->sendBadRequest('This is not your wallet');
        }

        $expired = Carbon::now()->addYears(3);

        $data = [
            'user_wallet_id' => $getWallet->id,
            'expired_at' => $expired
        ];

        $newCard = $this->userWalletCardRepository->createNewUserWalletCard($data);

        if($newCard){
            return $this->sendCreated($newCard,'Success Create Wallet Card');
        }else{
            return $this->sendBadRequest('Create Wallet Card Failed');
        }
    }

    public function updateCard($dataRequest)
    {
        $getWalletCard = $this->userWalletCardRepository->getUserWalletCardByCode($dataRequest['code']);

        if($getWalletCard->userWallet->user_id != $dataRequest['user']->id){
            return $this->sendBadRequest('This is not your card');
        }

        $data = [
            'daily_limit' => $dataRequest['daily_limit'],
            'monthly_limit' => $dataRequest['monthly_limit']
        ];

        $updateCard = $this->userWalletCardRepository->updateUserWalletCard($dataRequest['code'],$data);

        if($updateCard){
            return $this->sendSuccess($updateCard,'Update Card Success');
        }else{
            return $this->sendBadRequest('Update Card Failed');
        }
    }

    public function deleteCard($dataRequest)
    {
        $getWalletCard = $this->userWalletCardRepository->getUserWalletCardByCode($dataRequest['code']);

        if($getWalletCard->userWallet->user_id != $dataRequest['user']->id){
            return $this->sendBadRequest('This is not your card');
        }

        $deleteCard = $this->userWalletCardRepository->deleteCard($dataRequest['code']);

        if($deleteCard){
            return $this->sendSuccess([],'Delete Card Success');
        }

        return $this->sendBadRequest('Delete Card Failed');
    }

}