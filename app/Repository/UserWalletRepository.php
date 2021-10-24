<?php
namespace App\Repository;
use App\Models\UserWallet;

class UserWalletRepository{

    protected $modelUserWallet;

    public function __construct()
    {
        $this->modelUserWallet = new UserWallet();
    }

    public function getUserWalletActive()
    {
        return $this->modelUserWallet
            ->where('is_active','=',true)
            ->simplePaginate(10);
    }

    public function getUserWalletActiveByUserCode($code)
    {
        $user = $this->modelUserWallet
            ->whereRelation('user', 'code', '=', $code)
            ->where('is_active','=',true)
            ->orderBy('updated_at','desc')
            ->simplePaginate(10);
       
        return $user;
    }

    public function getUserWalletByCode($code)
    {
        return $this->modelUserWallet->where('code','=',$code)->firstOrFail();
    }


    public function getUserWallet()
    {
        return $this->modelUserWallet;
    }

    public function createNewUserWallet($data)
    {
        $data['code'] = randomString();
        return $this->modelUserWallet->create($data);
    }
    

    public function updateUserWallet($code,$data)
    {
        return tap($this->getUserWallet()->where('code','=',$code))->update($data)->first();;
    }
}