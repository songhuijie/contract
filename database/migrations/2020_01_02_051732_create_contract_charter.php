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
            $table->bigIncrements('id');
            $table->string('name')->comment('法人姓名');
            $table->string('ID_crad')->comment('法人身份证号');
            $table->string('company_name')->default(null)->comment('公司名称');
            $table->string('certificate_number')->default(null)->comment('证书编号');
            $table->string('official_seal_number')->default(null)->comment('公章编号');
            $table->string('business_license')->default(null)->comment('营业执照');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('type')->default(1)->comment('类型 1个人 2 公司');
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
