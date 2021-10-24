<?php
namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\UserWalletCardRepository;
use App\Repository\UserWalletRepository;

class UserService extends BaseService{

    protected $userRepository,$userWalletRepository,$userWalletCardRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->userWalletRepository = new UserWalletRepository;
        $this->userWalletCardRepository = new UserWalletCardRepository;

    }

    public function getUserActive()
    {
        $user =  $this->userRepository->getUserActive();

        return $this->sendSuccess($user);
    }

    public function getUserDetailByCode($code)
    {
        $user = $this->userRepository
            ->getUser()->with('userWallet')
            ->where('code','=',$code)
            ->first();

        return $this->sendSuccess($user);
    }


    public function getUserByCode($user)
    {
        $user = $this->userRepository
            ->getUser()->with('userWallet')
            ->where('code','=',$user->code)
            ->first();

        return $user;
    }

    public function deleteUser($code)
    {
        try{

            $user = $this->userRepository
                ->getUser()
                ->where('code','=',$code)
                ->first();  

            if(!$user){
                return $this->sendNotFound();
            }

            $deleteWallet = $this->userWalletRepository
                ->getUserWallet()->where('user_id',$user->id)
                ->delete();
            $deleteUser = $user->delete();

            return $this->sendSuccess([],'Delete User Success');
            
        }catch(\Exception $e){

            return $this->sendBadRequest($e->getMessage());
        }
    }

}