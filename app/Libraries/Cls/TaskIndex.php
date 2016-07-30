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

class TaskIndex extends BaseClass
{
    protected $state = -1;
    protected $enter_type = -1;
    protected $search = null;
    protected $keywords = null;
    protected $order_by = 'id';
    protected $dir = 'desc';
    protected $page_size;
    //类
    protected $mTask;

    //数据
    protected $tasks;

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
        $this->mTask = new App\Task();
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
                'mTask',
                'tasks',
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
        $a = App\Task::TABLE;

        if ($this->state == -1) {
            //不限
        }else{
            //禁用
            $query = $query->where($a . '.state',$this->state);
        }

        if ($this->enter_type == -1) {
            //不限
        }else{
            $query = $query->where($a . '.enter_type',$this->enter_type);
        }

        //查询条件
        if($this->search != '' && $this->keywords != ''){

            switch($this->search){
                case 'name':
                case 'keyword':
                case 'url':
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

        $t = App\Task::TABLE;
        $u = App\User::TABLE;

        $query = $this->mTask
            ->leftJoin($u, $u . '.id', '=', $t . '.user_id');

        //查询条件
        $query = $this->search_where($query);

        //查询
        $this->tasks = $query->select(DB::raw("
            $t.id,
            $t.user_id,
            $t.name,
            $t.state,
            $t.enter_type,
            $t.url,
            $t.keyword,
            $t.per_pv,
            $t.per_pv_spread,
            $t.start_time,
            $t.end_time,
            $t.created_at,
            $t.updated_at,
            $u.name AS user_name,
            $u.realname AS user_realname,
            $u.email AS user_email
        "))->paginate($this->page_size);

        return $this->tasks;
    }

    /**
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
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
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function getEnterType()
    {
        return $this->enter_type;
    }
}