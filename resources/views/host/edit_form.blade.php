{!! Form::open(array('action' => array('HostController@update',$id),'class'=>'ui form')) !!}

<div class="field">
    <label>所属上级</label>
    <input type="text" name="parent_id" value="{{$host->parent_id}}">
</div>
<div class="field">
    <label>主机名称</label>
    <input type="text" name="name" value="{{$host->name}}">
</div>
<div class="field">
    <label>主机编号</label>
    <input type="text" name="code" value="{{$host->code}}">
</div>

<div class="inline fields">
    <label for="fruit">状态</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if(!$host->disabled_at) checked="checked" @endif class="hidden" value="0">
            <label>启用</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if($host->disabled_at) checked="checked" @endif class="hidden" value="1">
            <label>禁用</label>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui button']) !!}

{!! Form::close() !!}