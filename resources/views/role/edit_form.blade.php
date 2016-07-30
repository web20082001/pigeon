{!! Form::open(array('action' => array('RoleController@update',$id),'class'=>'ui form')) !!}


<div class="field">
    <label>名称</label>
    <input type="text" name="name" value="{{$role->name}}">
</div>
<div class="field">
    <label>描述</label>
    <input type="text" name="memo" value="{{$role->memo}}">
</div>

<div class="inline fields">
    <label for="fruit">状态</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if(!$role->disabled_at) checked="checked" @endif class="hidden" value="0">
            <label>启用</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if($role->disabled_at) checked="checked" @endif class="hidden" value="1">
            <label>禁用</label>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui button']) !!}

{!! Form::close() !!}