<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostTable extends Migration
{
    const TABLE = 'host';
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
            $table->string('username',100);
            $table->string('password',32);
            $table->string('memory',10);
            $table->integer('area_id');
            $table->string('remote_addr',30);
            $table->tinyInteger('state')->default(1);
            $table->string('adsl_username',100);
            $table->string('adsl_password',100);
            $table->string('contact',50);
            $table->decimal('month_fee',10,2);
            $table->decimal('quarter_fee',10,2);
            $table->timestamp('expire_time',100);
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
