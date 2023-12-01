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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
			$table->string('plan_name', 100)->nullable()->default('');
			$table->float('daily_percentage')->nullable()->default(00.0);
			$table->float('min_amount')->nullable()->default(00.0);
			$table->float('max_amount')->nullable()->default(00.0);
			$table->integer('plan_duration')->unsigned()->nullable()->default(0);
			$table->float('referral_percentage')->nullable()->default(00.0);
			$table->float('bonus_percentage')->nullable()->default(00.0);
			$table->string('status', 100)->nullable()->default('Inactive');
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
        Schema::dropIfExists('plans');
    }
};
