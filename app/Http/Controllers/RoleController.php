<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class RoleController extends Controller
{
    const CONTROLLER_NAME = 'role';

    private $clsRole;
    private $clsRoleIndex;

    function __construct()
    {
        $this->clsRole = new App\Libraries\Cls\Role();
        $this->clsRoleIndex = new App\Libraries\Cls\RoleIndex();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsRoleIndex->search($request);

        //获取数据
        $roles = $this->clsRoleIndex->getRoles();

        $clsRoleIndex = $this->clsRoleIndex;

        $sub_title = '权限列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'roles',
            'clsRoleIndex'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_title = '权限添加';

        return view(self::CONTROLLER_NAME.'/create',compact(
            'sub_title'
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
            'name',
            'memo',
            'disabled_at'
        );

        //验证
        $validator = App\Role::storeValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //添加
        $add_rlt = $this->clsRole->add($input);

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
        $role = $this->clsRole->getById($id);

        $sub_title = '权限修改';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'role'
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
            'name',
            'memo',
            'disabled_at'
        );

        //验证
        $validator = App\Role::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['id'] = $id;

        $up_rlt = $this->clsRole->update($input);

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
        $del_rlt = $this->clsRole->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}