<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateNotice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('title')->comment('标题');
            $table->text('content')->comment('内容');
            $table->integer('status')->default(0)->comment('状态0 未查看 1查看');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->comment = '通知记录';
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice');
    }
}
