<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:18
 */

namespace App\Libraries\Cls;

use Illuminate\Support\Facades\Config;
use App;
use DB;

class HostIndex extends BaseClass
{

    protected $disabled_at = 0;
    protected $area_id = -1;
    protected $search = 'code';
    protected $keywords = null;
    protected $order_by = 'id';
    protected $dir = 'desc';
    protected $page_size;
    //类
    protected $mHost;

    //数据
    protected $hosts;

    //排序链接
    protected $base_link;

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    public function __construct()
    {
        //默认分页
        $this->page_size = 20;
        $this->mHost = new App\Host();
    }


    /**
     * 填充变量
     * @param $request
     * @return mixed
     */
    function request_fill($request)
    {

        //设置参数
        if (!is_null($request)) {

            $reflect = new \ReflectionObject($this);
            $props = $reflect->getProperties();

            //方法一，获取内部成员，全部赋值
            $vars = [];
            foreach ($props as $p) {
                array_push($vars, $p->getName());
            }

            //要排除的
            $un_set_vars = [
                'mHost',
                'hosts',
                'base_link'
            ];

            foreach ($un_set_vars as $v) {

                $search_index = array_search($v, $vars);
                if ($search_index) {
                    unset($vars[$search_index]);
                }
            }

            //只获取指定的变量
            $params = $request->only($vars);

            //设置排序链接
            $this->base_link($request->path(), $params);

            //成员变量赋值
            foreach ($params as $k => $v) {
                if (!is_null($v)) {

                    $this->$k = $v;

                }
            }
        }
    }

    /**
     * 搜索条件
     * @param $query
     * @return mixed
     */
    function search_where($query)
    {
        //表别名
        $a = App\Host::TABLE;

        //地区
        if ($this->area_id > 0) {
            $query = $query->where($a . '.area_id',$this->area_id);
        }

        //故障状态
        if ($this->disabled_at == -1) {
            //不限
        }else if ($this->disabled_at == 0) {
            //启用
            $query = $query->whereNull($a . '.disabled_at');
        } else if ($this->disabled_at == 1){
            //禁用
            $query = $query->whereNotNull($a . '.disabled_at');
        }

        //查询条件
        if($this->search != '' && $this->keywords != ''){

            switch($this->search){
                case 'remote_addr':
                case 'code':
                case 'contact':

                    $query = $query->where($a.'.'.$this->search, 'like','%'.$this->keywords.'%');
                    break;
                default:
                    break;
            }
        }

        //排序
        $order_by = $this->order_by;

        $query = $query->orderBy($order_by, $this->dir);

        return $query;
    }


    /**
     * 搜索
     * @param $request
     */
    function search($request = null)
    {

        //设置参数
        if (!is_null($request)) {
            $this->request_fill($request);
        }

        $h = App\Host::TABLE;
        $a = App\Area::TABLE;

        $query = $this->mHost
            ->leftJoin($a, $a . '.id', '=', $h . '.area_id');

        //查询条件
        $query = $this->search_where($query);

        //查询
        $this->hosts = $query->select(DB::raw("
            $h.id,
            $h.username,
            $h.password,
            $h.memory,
            $h.code,
            $h.area_id,
            $h.remote_addr,
            $h.disabled_at,
            $h.adsl_username,
            $h.adsl_password,
            $h.contact,
            $h.month_fee,
            $h.quarter_fee,
            $h.expire_time,
            $h.created_at,
            $h.updated_at,
            $a.name AS area_name
        "))->paginate($this->page_size);

        return $this->hosts;
    }

    /**
     * @return mixed
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param $item
     * @return string
     */
    public function getBaseLink($item)
    {
        $dir = 'asc';
        if($this->order_by == $item){
            //如果排序相同
            $dir = ($this->dir == 'asc') ? 'desc' : 'asc';
        }

        return $this->base_link.'&order_by='.$item.'&dir='.$dir;
    }

    /**
     * 获取分页
     * @param string $action
     * @param string $params
     * @return string
     */
    public function base_link($action, $params)
    {

        //去掉排序
        if (isset($params['dir'])) {
            unset($params['dir']);
        }

        //默认排序
        if (isset($params['order_by'])) {
            unset($params['order_by']);
        }

        $this->base_link = '/' . $action . '?' . http_build_query($params);

        return $this->base_link;
    }

    /**
     * @return int
     */
    public function getDisabledAt()
    {
        return $this->disabled_at;
    }

    /**
     * @return int
     */
    public function getAreaId()
    {
        return $this->area_id;
    }
}