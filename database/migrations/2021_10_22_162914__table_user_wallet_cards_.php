<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableUserWalletCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedInteger('user_wallet_id');
            $table->boolean('is_active')->default(true);;
            $table->double('daily_limit', 16, 2)->default(1000000);
            $table->double('monthly_limit',  16, 2)->default(10000000);
            $table->date('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet_cards');
    }
}
