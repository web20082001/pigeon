{!! Form::open(array('action' => array('HostController@update', $id),'class'=>'ui form')) !!}

<div class="field">
    <label>用户名</label>
    <input type="text" name="username" value="{{$host->username}}">
</div>
<div class="field">
    <label>密码</label>
    <input type="text" name="password" value="{{$host->password}}">
</div>
<div class="field">
    <label>内存</label>
    <input type="text" name="memory" value="{{$host->memory}}">
</div>

<div class="field">
    <label>主机编号</label>
    <input type="text" name="code" value="{{$host->code}}">
</div>

<h4 class="ui header">地区</h4>
<select name="area_id" class="ui fluid normal dropdown">
    <option value="-1">请选择</option>
    @foreach ($areas as $a)
        <option value="{{$a->id}}"@if($a->id == $host->area_id) selected @endif>{{$a->name}}</option>
    @endforeach
</select>


<div class="field">
    <label>远程主机地址</label>
    <input type="text" name="remote_addr" value="{{$host->remote_addr}}">
</div>

<div class="field">
    <label>ADSL用户名</label>
    <input type="text" name="adsl_username" value="{{$host->adsl_password}}">
</div>

<div class="field">
    <label>ADSL密码</label>
    <input type="text" name="adsl_password" value="{{$host->adsl_username}}">
</div>

<div class="field">
    <label>购买联系人</label>
    <input type="text" name="contact" value="{{$host->contact}}">
</div>
<div class="field">
    <label>月费用</label>
    <input type="text" name="month_fee" value="{{$host->month_fee}}">
</div>
<div class="field">
    <label>季度费用</label>
    <input type="text" name="quarter_fee" value="{{$host->quarter_fee}}">
</div>
<div class="field">
    <label>过期时间</label>
    <input type="text" name="expire_time" value="{{$host->expire_time}}">
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
{!! Form::submit('添加',['class'=>'ui button']) !!}

{!! Form::close() !!}