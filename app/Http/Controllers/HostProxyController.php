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

        $sub_title = '代理列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'host_proxys',
            'clsHostProxyIndex',
            'areas'
        ));
    }
}