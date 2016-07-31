{!! Form::open(array('action' => array('UserController@postAction'),'class'=>'ui form')) !!}

<div class="field">
    <label>真实姓名</label>
    {{$user->realname}}
</div>

<div class="field">
    <label>邮箱</label>
    {{$user->email}}
</div>


<div class="field">
    <label>原密码</label>
    <input type="password" name="old_password" value="">
</div>


<div class="field">
    <label>新密码</label>
    <input type="password" name="new_password" value="">
</div>

<input type="hidden" name="user_id" value="{{$id}}">
<input type="hidden" name="action" value="password_edit">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui button']) !!}

{!! Form::close() !!}