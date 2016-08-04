<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;
use Auth;

class IndexController extends Controller
{

    function __construct()
    {

    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
/*        if (Auth::attempt(['email' => 'xiaoxiao@qq.com', 'password' => '123456'])) {
            // Authentication passed...

            return 'yes';
        }else{
            return 'no';
        }*/

//        $user = Auth::user();
//        $user->password = bcrypt('111111');
//        $a = $user->save();

//        var_dump($a);



//        Auth::loginUsingId(2);
//        return 'a';
    }
}