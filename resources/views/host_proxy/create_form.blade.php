{!! Form::open(array('action' => array('HostController@store'),'class'=>'ui form')) !!}

    <div class="field">
        <label>用户名</label>
        <input type="text" name="username">
    </div>
    <div class="field">
        <label>密码</label>
        <input type="text" name="password">
    </div>
    <div class="field">
        <label>内存</label>
        <input type="text" name="memory">
    </div>


    <h4 class="ui header">代理</h4>
    <select name="area_id" class="ui fluid normal dropdown">
        <option value="-1">请选择</option>
        @foreach ($areas as $a)
            <option value="{{$a->id}}">{{$a->name}}</option>
        @endforeach
    </select>


    <div class="field">
        <label>远程主机地址</label>
        <input type="text" name="remote_addr">
    </div>

    <div class="field">
        <label>ADSL用户名</label>
        <input type="text" name="adsl_password">
    </div>

    <div class="field">
        <label>ADSL密码</label>
        <input type="text" name="adsl_username">
    </div>

    <div class="field">
        <label>购买联系人</label>
        <input type="text" name="contact">
    </div>
    <div class="field">
        <label>月费用</label>
        <input type="text" name="month_fee">
    </div>
    <div class="field">
        <label>季度费用</label>
        <input type="text" name="quarter_fee">
    </div>
    <div class="field">
        <label>过期时间</label>
        <input type="text" name="expire_time">
    </div>


    <div class="inline fields">
        <label for="fruit">状态</label>
        <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" name="disabled_at" checked="checked" class="hidden" value="0">
                <label>启用</label>
            </div>
        </div>
        <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" name="disabled_at" class="hidden" value="1">
                <label>禁用</label>
            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::submit('添加',['class'=>'ui primary button']) !!}

{!! Form::close() !!}