<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateCertification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certification', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('name')->comment('身份证姓名');
            $table->string('ID_card')->comment('身份证号');
            $table->string('identity_card_positive')->comment('身份证正面');
            $table->string('identity_card_back')->comment('身份证背面');
            $table->integer('status')->default(0)->comment('审核状态 0审核中 1审核通过  2审核未通过');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->comment = '实名认证';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certification');
    }
}
