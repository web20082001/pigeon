<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * 失败
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function json_error($message = '', $data = array()) {
        return $this->json_out ( 0, $message, $data );
    }



    /**
     * 成功
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function json_success($message = '', $data = array()) {
        return $this->json_out ( 1, $message, $data );
    }


    /**
     * 输出json
     * @param $success
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function json_out($success,$message='',$data = array()){
        return response()->json([
            'success'	=>$success,
            'message'	=>$message,
            'data'		=>$data
        ]);
    }

    function withSuccess($response,$message = '操作成功',$data=[]){
        return $response->with('success',$message)->with('data',$data);
    }

    function withError($response,$message = '操作失败',$data=[]){
        return $response->with('error',$message)->with('data',$data);
    }
}
