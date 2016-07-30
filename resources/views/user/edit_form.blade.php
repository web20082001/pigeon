{!! Form::open(array('action' => array('UserController@update',$id),'class'=>'ui form')) !!}

<div class="field">
    <label>真实姓名</label>
    <input type="text" name="realname" value="{{$user->realname}}">
</div>

<div class="field">
    <label>邮箱</label>
    <input type="text" name="email" value="{{$user->email}}">
</div>

<h4 class="ui header">权限</h4>
<select name="role_id" class="ui fluid normal dropdown">
    <option value="-1">不限</option>
    @foreach ($roles as $r)
        <option value="{{$r->id}}" @if($r->id == $user->role_id) selected @endif>{{$r->name}}</option>
    @endforeach
</select>


<div class="inline fields">
    <label for="fruit">状态</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if(!$user->disabled_at) checked="checked" @endif class="hidden" value="0">
            <label>启用</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if($user->disabled_at) checked="checked" @endif class="hidden" value="1">
            <label>禁用</label>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui button']) !!}

{!! Form::close() !!}