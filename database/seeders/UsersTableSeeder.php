<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser1 = User::create([
            'email'    => 'strevecloud@gmail.com',
            'phone' => '085729427427',
            'password'    => Hash::make(12345678),
            'code' => randomString()
         ]);

         $newWallet = UserWallet::create([
            'code' => randomString(),
            'user_id' => $newUser1->id
         ]);

         $newUser2 = User::create([
            'email'    => 'sefriandsz@gmail.com',
            'phone' => '08562605588',
            'password'    => Hash::make(12345678),
            'code' => randomString()
         ]);

         $newWallet2 = UserWallet::create([
            'code' => randomString(),
            'user_id' => $newUser2->id
         ]);
    }
}
