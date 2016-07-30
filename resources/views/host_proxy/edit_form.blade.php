{!! Form::open(array('action' => array('HostController@update', $id),'class'=>'ui form')) !!}

<div class="field">
    <label>用户名</label>
    <input type="text" name="username" value="{{$host_proxy->username}}">
</div>
<div class="field">
    <label>密码</label>
    <input type="text" name="password" value="{{$host_proxy->password}}">
</div>
<div class="field">
    <label>内存</label>
    <input type="text" name="memory" value="{{$host_proxy->memory}}">
</div>


<h4 class="ui header">代理</h4>
<select name="area_id" class="ui fluid normal dropdown">
    <option value="-1">请选择</option>
    @foreach ($areas as $a)
        <option value="{{$a->id}}"@if($a->id == $host_proxy->area_id) selected @endif>{{$a->name}}</option>
    @endforeach
</select>


<div class="field">
    <label>远程主机地址</label>
    <input type="text" name="remote_addr" value="{{$host_proxy->remote_addr}}">
</div>

<div class="field">
    <label>ADSL用户名</label>
    <input type="text" name="adsl_username" value="{{$host_proxy->adsl_password}}">
</div>

<div class="field">
    <label>ADSL密码</label>
    <input type="text" name="adsl_password" value="{{$host_proxy->adsl_username}}">
</div>

<div class="field">
    <label>购买联系人</label>
    <input type="text" name="contact" value="{{$host_proxy->contact}}">
</div>
<div class="field">
    <label>月费用</label>
    <input type="text" name="month_fee" value="{{$host_proxy->month_fee}}">
</div>
<div class="field">
    <label>季度费用</label>
    <input type="text" name="quarter_fee" value="{{$host_proxy->quarter_fee}}">
</div>
<div class="field">
    <label>过期时间</label>
    <input type="text" name="expire_time" value="{{$host_proxy->expire_time}}">
</div>


<div class="inline fields">
    <label for="fruit">状态</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if(!$host_proxy->disabled_at) checked="checked" @endif class="hidden" value="0">
            <label>启用</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if($host_proxy->disabled_at) checked="checked" @endif class="hidden" value="1">
            <label>禁用</label>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('添加',['class'=>'ui button']) !!}

{!! Form::close() !!}