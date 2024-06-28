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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('type')->nullable()->comment('0: 一般使用者 1: 管理者');
            $table->string('name')->nullable()->comment('賬號');
            $table->string('password')->nullable()->comment('密碼');
            $table->string('username')->nullable()->comment('使用者名稱');
            $table->integer('enabled')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('admin_enabled')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
