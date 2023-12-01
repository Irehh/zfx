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
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
			$table->string('reference_id', 100)->nullable()->default('');
			$table->float('amount')->nullable()->default(00.0);
            $table->date('date')->nullable();
			$table->string('deposit_method');
			$table->float('deposit_charge')->nullable()->default(1.0);
			$table->string('status', 100)->nullable()->default('');
            $table->float('total_balance')->nullable();
            $table->enum('condition', ['open', 'closed', ''])->default('');
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
        Schema::dropIfExists('deposits');
    }
};
