{!! Form::open(array('action' => array('SoftwareController@update',$id),'class'=>'ui form')) !!}


<div class="field">
    <label>名称</label>
    <input type="text" name="name" value="{{$software->name}}">
</div>
<div class="field">
    <label>编号</label>
    <input type="text" name="code" value="{{$software->code}}">
</div>
<div class="field">
    <label>版本</label>
    <input type="text" name="version" value="{{$software->version}}">
</div>

<div class="field">
    <label>下载地址</label>
    <input type="text" name="url" value="{{$software->url}}">
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui primary button']) !!}

{!! Form::close() !!}