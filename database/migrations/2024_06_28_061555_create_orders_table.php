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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('type')->default(0)->comment('0: 工作單 1： 維修單');
            $table->date('order_date')->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_number')->default(0);
            $table->date('appointment_date')->nullable()->comment('預計日期');
            $table->date('finish_date')->nullable()->comment('完工日期');
            $table->date('start')->nullable()->comment('保固 start');
            $table->date('end')->nullable()->comment('保固 end');
            $table->string('worker')->nullable()->comment('施工人員');
            $table->string('source')->nullable()->comment('來源');
            $table->text('memo')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('work_status')->default(0)->comment('0: 未完工 1: 已經完工');
            $table->string('fix_description')->nullable()->comment('問題說明');
            $table->string('fix_item')->nullable()->comment('維修項目');
            $table->string('fix_method')->nullable()->comment('維修方式');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('special_price')->default(0)->comment('優惠價');
            $table->integer('ttl_price')->comment('總金額');
            $table->integer('service_id')->nullable()->comment('客服人員 ID');
            $table->integer('order_type')->nullable()->comment('0： 自行安裝 1: 其他派工');
            $table->string('order_descr')->nullable()->comment('order_type = 1, 記録用');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
