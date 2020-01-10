<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateContractCharter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_charter', function (Blueprint $table) {
            $table->bigIncrements('user_id')->comment('用户ID');
            $table->string('name')->comment('法人姓名');
            $table->string('ID_card')->comment('法人身份证号');
            $table->string('company_name')->nullable()->comment('公司名称');
            $table->string('certificate_number')->nullable()->comment('证书编号');
            $table->string('official_seal_number')->nullable()->comment('公章编号');
            $table->string('business_license')->nullable()->comment('营业执照');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('charter_type')->default(1)->comment('类型 1个人 2 公司');
            $table->integer('status')->default(0)->comment('审核 0审核中 1审核通过  2审核未通过');
            $table->string('charter_pic')->nullable()->comment('印章图片');
            $table->comment = '合同章';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_charter');
    }
}
