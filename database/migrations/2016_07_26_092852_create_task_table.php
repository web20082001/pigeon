<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    const TABLE = 'task';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id',11);
            $table->string('name',255);
            $table->tinyInteger('state',2)->default(2);
            $table->tinyInteger('enter_type',4)->default(1);
            $table->string('url',255);
            $table->string('keyword',255);
            $table->integer('per_pv',100,true);
            $table->longText('per_pv_spread');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop(self::TABLE);
    }
}
