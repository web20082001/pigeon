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
//        `` varchar(100) NOT NULL COMMENT '登录名',
//  `password` varchar(32) NOT NULL COMMENT '登录密码',
//  `memory` varchar(10) NOT NULL COMMENT '内存',
//  `area_id` int(10) unsigned NOT NULL COMMENT '所属区域',
//  `adsl_username` int(11) NOT NULL COMMENT 'adsl账号',
//  `adsl_password` int(11) NOT NULL COMMENT 'adsl密码',
//  `contact` varchar(50) NOT NULL COMMENT '购买商家联系方式',
//  `expire_time` datetime NOT NULL COMMENT '过期时间',
//  `month_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '月费用',
//  `quarter_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '季度费用',
//  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '主机状态',
//  `remote_addr` varchar(30) NOT NULL COMMENT '远程管理地址192.168.100.150:65535',

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username',100);
            $table->string('password',32);
            $table->string('memory',10);
            $table->integer('area_id',10,true);
            $table->string('remote_addr',30);
            $table->tinyInteger('state',2)->default(1);
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
