<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class HostController extends Controller
{
    const CONTROLLER_NAME = 'host';

    private $clsHost;
    private $clsHostIndex;
    private $clsArea;

    function __construct()
    {
        $this->clsHost = new App\Libraries\Cls\Host();
        $this->clsHostIndex = new App\Libraries\Cls\HostIndex();
        $this->clsArea = new App\Libraries\Cls\Area();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsHostIndex->search($request);

        //获取数据
        $hosts = $this->clsHostIndex->getHosts();

        //所有城市
        $areas = $this->clsArea->cities();

        $clsHostIndex = $this->clsHostIndex;

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'hosts',
            'clsHostIndex',
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
        $areas = $this->clsArea->cities();

        $expire_time = short_date();

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/create',compact(
            'sub_title',
            'areas',
            'expire_time',
            'cities'
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
            'code',
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

        //验证
        $validator = App\Host::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //添加
        $add_rlt = $this->clsHost->add($input);

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
        $host = $this->clsHost->getById($id);
        // 地区
        $areas = $this->clsArea->cities();

        $sub_title = '主机列表';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'host',
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
            'code',
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

        //验证
        $validator = App\Host::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['id'] = $id;

        $up_rlt = $this->clsHost->update($input);

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
        $del_rlt = $this->clsHost->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}