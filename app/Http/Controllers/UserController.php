<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class UserController extends Controller
{
    const CONTROLLER_NAME = 'user';

    private $clsUser;
    private $clsRole;
    private $clsUserIndex;

    function __construct()
    {
        $this->clsUser = new App\Libraries\Cls\User();
        $this->clsRole = new App\Libraries\Cls\Role();

        $this->clsUserIndex = new App\Libraries\Cls\UserIndex();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsUserIndex->search($request);

        //获取数据
        $users = $this->clsUserIndex->getUsers();

        $sub_title = '用户列表';

        $clsUserIndex = $this->clsUserIndex;

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'users',
            'clsUserIndex'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_title = '用户列表';
        //权限
        $roles = $this->clsRole->all();

        return view(self::CONTROLLER_NAME.'/create',compact(
            'sub_title',
            'roles'
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
            'realname',
            'password',
            'email',
            'disabled_at',
            'role_id'
        );

        //验证
        $validator = App\User::storeValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //添加
        $add_rlt = $this->clsUser->add($input);

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
        $user = $this->clsUser->getById($id);

        //权限
        $roles = $this->clsRole->all();

        $sub_title = '用户编辑';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'user',
            'roles'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password($id)
    {
        $user = $this->clsUser->getById($id);

        //权限
        $roles = $this->clsRole->all();

        $sub_title = '密码修改';

        return view(self::CONTROLLER_NAME.'/password',compact(
            'sub_title',
            'id',
            'user',
            'roles'
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
            'realname',
            'role_id',
            'disabled_at'
        );

        //验证
        $validator = App\User::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['id'] = $id;

        $up_rlt = $this->clsUser->update($input);

        if($up_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '保存成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '保存失败');
        }

        return $rsp;
    }


    public function postAction(Request $request){

        //验证是否是本组的
        $input = $request->only([
            'action',
            'user_id',
            'old_password',
            'new_password'
        ]);

        //动作
        $action = $input['action'];

        switch($action){
            case 'password_edit':

                $input['old_password'] = null;

                //修改密码
                $change_success = $this->clsUser->password_change($input['user_id'],$input['new_password'],$input['old_password']);

                if($change_success){
                    $rsp = $this->withSuccess(redirect()->back(), '密码修改成功');
                }else{
                    $rsp = $this->withSuccess(redirect()->back(), '密码修改失败:'.$this->clsUser->getErrorMsg());
                }

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
        $del_rlt = $this->clsUser->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}