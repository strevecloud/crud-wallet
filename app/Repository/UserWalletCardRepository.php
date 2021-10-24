<?php
namespace App\Repository;
use App\Models\UserWalletCard;

class UserWalletCardRepository{

    protected $modelUserWalletCard;

    public function __construct()
    {
        $this->modelUserWalletCard = new UserWalletCard();
    }

    public function getUserWalletCardActive()
    {
        return $this->modelUserWalletCard
            ->where('is_active','=',true)
            ->simplePaginate(10);
    }

    public function getUserWalletCardActiveByUserWalletCode($code)
    {

        $card = $this->modelUserWalletCard
            ->whereRelation('userWallet', 'code', '=', $code)
            ->where('is_active','=',true)
            ->orderBy('updated_at','desc')
            ->simplePaginate(10);
       
        return $card;
    }

    public function getUserWalletCardActiveByUserCode($code)
    {

        $card = $this->modelUserWalletCard->with('userWallet')
            ->whereRelation('userWallet.user', 'code', '=', $code)
            ->where('is_active','=',true)
            ->orderBy('updated_at','desc')
            ->simplePaginate(10);
       
        return $card;
    }

    public function getUserWalletCardByCode($code)
    {
        return $this->modelUserWalletCard->with('userWallet')->where('code','=',$code)->firstOrFail();
    }


    public function getUserWalletCard()
    {
        return $this->modelUserWalletCard;
    }

    public function createNewUserWalletCard($data)
    {
        $data['code'] = randomString();
        return $this->modelUserWalletCard->create($data);
    }
    

    public function updateUserWalletCard($code,$data)
    {
        return tap($this->getUserWalletCard()->where('code','=',$code))->update($data)->first();
    }

    public function deleteCard($code)
    {
        return $this->getUserWalletCard()->where('code','=',$code)->delete();
    }
}