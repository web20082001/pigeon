<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class HostProxyController extends Controller
{
    const CONTROLLER_NAME = 'host_proxy';

    private $clsHostProxy;
    private $clsHostProxyIndex;
    private $clsArea;

    function __construct()
    {
        $this->clsHostProxy = new App\Libraries\Cls\HostProxy();
        $this->clsHostProxyIndex = new App\Libraries\Cls\HostProxyIndex();
        $this->clsArea = new App\Libraries\Cls\Area();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsHostProxyIndex->search($request);

        //获取数据
        $host_proxys = $this->clsHostProxyIndex->getHostProxys();

        // 地区
        $areas = $this->clsArea->all();

        $clsHostProxyIndex = $this->clsHostProxyIndex;

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'host_proxys',
            'clsHostProxyIndex',
            'areas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 地区
        $areas = $this->clsArea->all();

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/create',compact(
            'sub_title',
            'areas'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(
            'username',
            'password',
            'memory',
            'area_id',
            'remote_addr',
            'disabled_at',
            'adsl_username',
            'adsl_password',
            'contact',
            'month_fee',
            'quarter_fee',
            'expire_time'
        );

        //添加
        $add_rlt = $this->clsHostProxy->add($input);

        if($add_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '添加成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '添加失败');
        }

        return $rsp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $host_proxy = $this->clsHostProxy->getById($id);
        // 地区
        $areas = $this->clsArea->all();

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'host_proxy',
            'areas'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(
            'username',
            'password',
            'memory',
            'area_id',
            'remote_addr',
            'disabled_at',
            'adsl_username',
            'adsl_password',
            'contact',
            'month_fee',
            'quarter_fee',
            'expire_time'
        );

        $input['id'] = $id;

        $up_rlt = $this->clsHostProxy->update($input);

        if($up_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '保存成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '保存失败');
        }

        return $rsp;
    }


    public function postAction(Request $request){

        //验证是否是本组的
        $input = $request->only(['action']);

        //动作
        $action = $input['action'];

        switch($action){
            case '':

                break;
            default:
                $rsp = $this->withError(redirect(self::CONTROLLER_NAME), '未找到对应处理程序');
                break;
        }

        return $rsp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del_rlt = $this->clsHostProxy->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}