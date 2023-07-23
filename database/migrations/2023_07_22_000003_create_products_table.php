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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->unsignedInteger('category_id');
            $table->text('features')->nullable();
            $table->text('description')->nullable();
            $table->double('buy_price')->default(0.00);
            $table->double('sell_price')->default(0.00);
            $table->tinyInteger('discount_type')->default(0)->comment('1.prcnt , 0.fixed');
            $table->double('discount_amount')->default(0.00);
            $table->tinyInteger('is_featured')->default(0)->comment('1.active, 0.inactive');
            $table->tinyInteger('is_active')->default(1)->comment('1.active, 2.inactive');
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
        Schema::dropIfExists('products');
    }
};
