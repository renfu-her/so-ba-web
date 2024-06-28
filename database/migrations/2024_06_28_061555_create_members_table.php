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
        Schema::create('members', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->integer('sex')->default(0)->comment('0: 女性 1: 男性');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('county')->nullable();
            $table->string('district')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->text('memo')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
