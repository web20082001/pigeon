<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 14:12
 */

namespace App\Libraries\Cls;
use Illuminate\Support\Facades\Config;
use App;
use DB;

class UserIndex extends BaseClass
{

    protected $disabled_at = -1;


    protected $search = null;
    protected $keywords = null;
    protected $order_by = 'id';
    protected $dir = 'desc';
    protected $page_size;
    //类
    protected $mUser;

    //数据
    protected $users;

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
        $this->mUser = new App\User();
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
                'mUser',
                'users',
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
        $a = App\User::TABLE;

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
                case 'name':
                case 'code':
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

        $a = App\User::TABLE;

        $query = $this->mUser;

        //查询条件
        $query = $this->search_where($query);

        //查询
        $this->users = $query->select(DB::raw("
            $a.id,
            $a.parent_id,
            $a.level,
            $a.name,
            $a.code,
            $a.order_sort,
            $a.disabled_at,
            $a.created_at,
            $a.updated_at
        "))->paginate($this->page_size);

        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
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
}