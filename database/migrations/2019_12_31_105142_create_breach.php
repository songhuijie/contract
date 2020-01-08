<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateBreach extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breach', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('executor_name')->comment('被执行人名');
            $table->integer('sex')->default(1)->comment('性别 1为男2为女');
            $table->integer('age')->comment('年龄');
            $table->string('ID_card')->comment('身份证号');
            $table->string('province')->comment('省份');
            $table->string('executor_court')->comment('执行法院');
            $table->string('case_number')->comment('案号');
            $table->string('register_time')->comment('立案时间');
            $table->string('symbol_number')->comment('执行依据文号');
            $table->string('execution_unit')->comment('做出执行依据单位');
            $table->string('obligation')->comment('生效法律文书确定的义务');
            $table->integer('performance')->comment('被执行人的履行情况');
            $table->integer('circumstances')->comment('失信执行人行为具体情况');
            $table->integer('release_time')->comment('发布时间');
            $table->comment = '失信被执行人表';
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breach');
    }
}
