<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App;

use DB, Auth;
class AreaController extends Controller
{
    const CONTROLLER_NAME = 'area';
    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $area_model = new App\Area();

        $areas = App\Area::all();

        return view(self::CONTROLLER_NAME.'/index',compact(
            'areas'
        ));
    }
}
