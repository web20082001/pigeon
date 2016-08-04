<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class SoftwareController extends Controller
{
    const CONTROLLER_NAME = 'software';

    private $clsSoftware;
    private $clsSoftwareIndex;

    function __construct()
    {
        $this->clsSoftware = new App\Libraries\Cls\Software();
        $this->clsSoftwareIndex = new App\Libraries\Cls\SoftwareIndex();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsSoftwareIndex->search($request);

        //获取数据
        $softwares = $this->clsSoftwareIndex->getSoftwares();

        $clsSoftwareIndex = $this->clsSoftwareIndex;

        $sub_title = '软件列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'softwares',
            'clsSoftwareIndex'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sub_title = '软件列表';

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
            'code',
            'version',
            'url'
        );

        //验证
        $validator = App\Software::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //添加
        $add_rlt = $this->clsSoftware->add($input);

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
        $software = $this->clsSoftware->getById($id);

        $sub_title = '软件修改';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'software'
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
            'code',
            'version',
            'url'
        );

        //验证
        $validator = App\Software::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['id'] = $id;

        $up_rlt = $this->clsSoftware->update($input);

        if($up_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '保存成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '保存失败');
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
        $del_rlt = $this->clsSoftware->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}