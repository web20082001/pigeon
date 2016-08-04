<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;
use Illuminate\Support\Str;

class User extends BaseClass
{
    private $mUser;

    function __construct(){
        $this->mUser = new App\User();
        $this->model = $this->mUser;
    }

    function add($input){
        $this->mUser = model_update($this->mUser,$input);
        return $this->mUser->save($input);
    }

    /**
     * 修改密码
     * @param $user_id
     * @param $new_password
     * @param null $old_password
     * @return bool
     */
    function password_change($id,$new_password,$old_password=null){

        //用户
//        $user = $this->user();

        $user = $this->getById($id);

    /*
        if(!is_null($old_password)){
            //验证原密码是否正确
            $is_pass = $this->password_check($user_id, $old_password);

            if(!$is_pass){
                $this->error_msg = '原密码不正确';
                return false;
            }
        }
    */

        //密码正确
        # $user->password = $this->password_bcrypt($new_password);

        $user->password = $new_password;
        return $user->save();

//        return $user->update([
//            'password' => $this->password_bcrypt($new_password)
//        ]);
    }

    /**
     * 校验密码是否正确
     * @param $user_id
     * @param $old_password
     * @return bool
     */
    function password_check($user_id, $old_password){

        //用户
        $user = $this->getById($user_id);

        //验证原密码是否正确
        if($this->password_bcrypt($old_password) == $user->password){
            return true;
        }else{
            return false;
        }

    }

    function password_bcrypt($password){
        return bcrypt($password);
    }
}