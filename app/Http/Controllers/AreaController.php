<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class AreaController extends Controller
{
    const CONTROLLER_NAME = 'area';

    private $clsArea;
    private $clsAreaIndex;

    function __construct()
    {
        $this->clsArea = new App\Libraries\Cls\Area();
        $this->clsAreaIndex = new App\Libraries\Cls\AreaIndex();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsAreaIndex->search($request);

        //获取数据
        $areas = $this->clsAreaIndex->getAreas();

        $clsAreaIndex = $this->clsAreaIndex;

        $sub_title = '地区列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'areas',
            'clsAreaIndex'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->only(
            'parent_id'
        );

        //上级地区
        $parent_id = intval($input['parent_id']);

        if($parent_id){
            //上级地区
            $area = $this->clsArea->getById($parent_id,$with=null,$fail=false);
            $parent_name = $area->name;
        }else{
            $parent_id = 0;
            $parent_name = '无';
        }

        //排序最大值
        $order_sort_max = $this->clsArea->order_sort_max();
        //加1
        $order_sort_max += 1;

        $sub_title = '地区列表';

        return view(self::CONTROLLER_NAME.'/create',compact(
            'parent_id',
            'parent_name',
            'order_sort_max',
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
            'parent_id',
            'name',
            'code',
            'order_sort',
            'disabled_at'
        );

        //验证
        $validator = App\Area::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //上级地区
        $parent_id = intval($input['parent_id']);

        $level = 0;

        if($parent_id){
            //上级地区
            $area = $this->clsArea->getById($parent_id,$with=null,$fail=true);
            $level = intval($area->level) + 1;
        }

        //级别
        $input['level'] = $level;

        //添加
        $add_rlt = $this->clsArea->add($input);

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
        $area = $this->clsArea->getById($id);

        $parent_id = $area->parent_id;

        if($parent_id){
            //上级地区
            $area_parent = $this->clsArea->getById($parent_id,$with=null,$fail=false);
            $parent_name = $area_parent->name;
        }else{
            $parent_id = 0;
            $parent_name = '无';
        }

        $sub_title = '地区列表';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'area',
            'parent_id',
            'parent_name'
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
            'order_sort',
            'disabled_at'
        );

        //验证
        $validator = App\Area::updateValidator($input);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['id'] = $id;

        $up_rlt = $this->clsArea->update($input);

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
        $del_rlt = $this->clsArea->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }
}