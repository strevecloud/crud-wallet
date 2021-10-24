<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletCard extends Model
{
    protected $fillable = ['code','user_wallet_id','daily_limit','monthly_limit','expired_at'];   

    public function userWallet()
    {
        return $this->belongsTo('App\Models\UserWallet','user_wallet_id');
    }
}
