<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable()->comment('商品名稱');
            $table->string('image')->nullable();
            $table->string('type_name')->nullable()->comment('型號');
            $table->decimal('price', 10, 0)->nullable()->comment('金額');
            $table->integer('order_number')->nullable()->comment('庫存量');
            $table->text('memo')->nullable();
            $table->integer('user_id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('type')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
