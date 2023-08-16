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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_phone')->nullable();
            $table->text('delivery_address')->nullable();
            $table->double('sub_total')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->double('total')->default(0);
            $table->string('status')->default('pending')->comment('pending, cancel, on the way, delivered');
            $table->string('order_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
