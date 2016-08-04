<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 11:00
 */

return [

        'task' => [

            # 任务状态
            'state' => [
                1 => '取消',
                2 => '暂停',
                3 => '开始',
                4 => '完成'
            ],

            'state_create' => [
                3 => '开始',
            ],

            'state_cancel' => [
                1 => '取消'
            ],

            'state_pause' => [
                1 => '取消',
                2 => '暂停',
                3 => '开始'
            ],

            'state_start' => [
                1 => '取消',
                2 => '暂停',
                3 => '开始'
            ],

            'state_finish' => [
                4 => '完成'
            ],

            //对应选择项
            'state_names' => [
                1 => 'state_cancel',
                2 => 'state_pause',
                3 => 'state_start',
                4 => 'state_finish'
            ],

            # 进入方式
            'enter_type' => [
                1 => '搜索'
            ]
        ]
];