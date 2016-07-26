<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTable extends Migration
{
    const TABLE = 'area';
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
            $table->integer('parent_id',10,true);
            $table->integer('level',11,true)->default(1);
            $table->string('name',100)->unique();
            $table->string('code',100)->unique();
            $table->integer('order_sort',10,true)->default(0);
            $table->timestamp('disabled_at');
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
