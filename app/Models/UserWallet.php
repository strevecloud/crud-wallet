<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = ['code','user_id','amount'];   

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function userWalletCard()
    {
        return $this->hasMany('App\Models\UserWalletCard','user_wallet_id');
    }
}
