<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
			$table->string('wallet_type', 100)->nullable()->default('');
			$table->string('wallet_address', 100)->nullable()->default('');
            $table->float('profit')->nullable()->default(00.0);
			$table->float('referal_bonus')->nullable()->default(00.0);
			$table->float('trading_bonus')->nullable()->default(00.0);
            $table->float('balance')->nullable()->default(00.0);
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
        Schema::dropIfExists('user_wallet');
    }
};
