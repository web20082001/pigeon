<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 10:05
 */


/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

/**
 * Created by PhpStorm.
 * User: lihuan
 * Date: 15-12-4
 * Time: 下午2:41
 */

function full_date($time = null){

    if(is_null($time)){
        $time = time();
    }
    return date('Y-m-d H:i:s',$time);
}


function short_date($time = null){

    if(is_null($time)){
        $time = time();
    }
    return date('Y-m-d',$time);
}


/**
 * 今天
 * @return bool|string
 */
function today(){
    return date('Y-m-d');
}


/**
 * 结束时间
 * @param $end_time
 * @return unknown
 */
function end_time_add($end_time){
    return full_date(strtotime($end_time) + 86400 - 1);
}



/**
 * 两日期秒差
 * @param $d1
 * @param $d2
 * @return float
 */
function seconds_span($d1,$d2){
    return abs(strtotime($d2) - strtotime($d1));
}

/**
 * 日期加时间间隔
 * @param $date
 * @param $seconds
 * @return unknown
 */
function date_add_seconds($date,$seconds){
    return full_date(strtotime($date) + $seconds);
}

/**
 * 为null设置默认值
 * @param $val
 * @param $set
 * @return mixed
 */
function is_null_set(&$val,$set=null){
    if(is_null($val)){
        $val = $set;
    }
    return $val;
}

/**
 * 为null默认值
 * @param $val
 * @param $get
 * @return mixed
 */
function is_null_get($val,$get=null){
    if(is_null($val)){
        return $get;
    }
    return $val;
}

/**
 * 变量是否存在
 *
 * @param unknown $value
 * @param string $default
 * @return unknown string
 */
function isset_set($value, $default = null) {
    if (isset ( $value )) {
        return $value;
    } else {
        return $default;
    }
}

/**
 * 获取集合指定列做映射数组
 * @param $collections
 * @param $key
 * @param $val
 * @return array
 */
function collection_map($collections,$key,$val){

    $map = [];
    $collections->each(function($item,$key) use(&$map,$key,$val){

        if(isset($item->$key)){
            $map[$item->$key] = isset_set($item->$val);
        }
    });

    return $map;
}


/**
 * 变量是否存在
 *
 * @param unknown $array
 * @param unknown $key
 * @param string $default
 * @return unknown string
 */
function key_exist_set($array,$key,$default = null) {
    if (array_key_exists($key,$array)) {
        return $array[$key];
    } else {
        return $default;
    }
}

/**
 * 缩短日期
 * @param $date
 * @return string
 */
function short_date_fmt($date){
    if(!is_null($date)){
        return substr($date,5,11);
    }else{
        return '';
    }
}


/**
 * 缩短日期
 * @param $date
 * @return string
 */
function short_time_fmt($date){
    if(!is_null($date)){
        return substr($date,10);
    }else{
        return '';
    }
}

/**
 * 格式化金额
 *
 * @param unknown_type $m
 * @return unknown
 */
function money($m){
    return number_format($m, 2, '.', '');
}

/**
 * csv避免科学计数法
 * @param unknown $num
 */
function csv_number_wrap($num){
    return '="'.$num.'"';
}

/**
 * @param $models 相同模型数组
 * @param $attribute 属性名称
 * @param array $emptyReturn 为空的时候返回值，默认空数组
 * @return array
 */
function models_attributes($models, $attribute, $emptyReturn=[]){

    $results =[];
    $models->each(function($item,$key) use(&$results,$attribute){
        array_push($results, $item->$attribute);
    });

    if(empty($results)){
        $results = $emptyReturn;
    }

    return $results;
}

/**
 * 更新模型
 * @param $model
 * @param $upItems
 * @return mixed
 */
function model_update($model, $upItems){

    foreach($upItems as $k =>$v){
        $model->$k = $v;
    }
    return $model;
}

function disabled_at_convert($value){

    $disabled_values = [
        '0' => null,
        '1' => full_date()
    ];

    return $disabled_values[$value];
}

function disabled_at_text($value){

    if(is_null($value)){
        $val = '启用';
    }else{
        $val = '禁用';
    }

    return $val;
}

/**
 * 两日期天数间隔
 * @param $d1
 * @param $d2
 * @return float
 */
function day_span($d1,$d2){

    $time_span = abs(strtotime($d2) - strtotime($d1));

    return floor($time_span / 86400);
}

/**
 * 当前小时
 * @return bool|string
 */
function current_date_hours(){
    return date('Y-m-d H:00:00');
}

/**
 * 下一小时
 * @return bool|string
 */
function next_date_hours(){
    return  full_date(strtotime(date('Y-m-d H:00:00')) + 3600 -1);
}