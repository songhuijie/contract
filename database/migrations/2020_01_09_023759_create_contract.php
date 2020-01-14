<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('specific_user_id')->default(0)->comment('指定用户ID');
            $table->integer('template_id')->default(0)->comment('模板ID');
            $table->text('template_content')->nullable()->comment('模板编辑后内容');
            $table->string('draft_information')->nullable()->comment('创建人或公司名称');
            $table->text('contract_title')->nullable()->comment('合同名称');
            $table->text('contract_demand')->nullable()->comment('需求描述');
            $table->integer('first_is_sign')->default(0)->comment('默认签署完毕 甲方 后期可更改');
            $table->integer('is_sign')->default(0)->comment('指定签署方(乙) 是否签署 0 未签署  1签署');
            $table->integer('contract_type')->default(1)->comment('合同类型 1系统模板 2律师代写');
            $table->decimal('price',8,2)->default(0)->comment('律师代写价格');
            $table->string('order_number')->nullable()->comment('支付订单号');
            $table->integer('status')->default(0)->comment('0待支付 1支付成功 2编写中 3待确认 4完成');
            $table->integer('create_time')->default(0)->comment('合同创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->comment = '合同表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract');
    }
}
