{!! Form::open(array('action' => array('HostController@store'),'class'=>'ui form')) !!}

    <div class="field">
        <label>用户名</label>
        <input type="text" name="username" value="{{old('username')}}">
    </div>
    <div class="field">
        <label>密码</label>
        <input type="text" name="password" value="{{old('password')}}">
    </div>
    <div class="field">
        <label>内存</label>
        <input type="text" name="memory" value="{{old('memory')}}">
    </div>

    <div class="field">
        <label>主机编号</label>
        <input type="text" name="code" value="{{old('code')}}">
    </div>

    <div class="field">
    <h4 class="ui header">城市</h4>
    <select name="area_id" class="ui fluid normal dropdown">
        <option value="-1">请选择</option>
        @foreach ($areas as $a)
            <option value="{{$a->id}}">{{$a->name}}</option>
        @endforeach
    </select>
    </div>

    <div class="field">
        <label>远程主机地址</label>
        <input type="text" name="remote_addr" value="{{old('remote_addr')}}">
    </div>

    <div class="field">
        <label>ADSL用户名</label>
        <input type="text" name="adsl_username" value="{{old('adsl_username')}}">
    </div>

    <div class="field">
        <label>ADSL密码</label>
        <input type="text" name="adsl_password" value="{{old('adsl_password')}}">
    </div>

    <div class="field">
        <label>购买联系人</label>
        <input type="text" name="contact" value="{{old('contact')}}">
    </div>
    <div class="field">
        <label>月费用</label>
        <input type="text" name="month_fee" value="{{old('month_fee')}}">
    </div>
    <div class="field">
        <label>季度费用</label>
        <input type="text" name="quarter_fee" value="{{old('quarter_fee')}}">
    </div>
    <div class="field">
        <label>过期时间</label>
        <input type="text" class="Wdate" id="begin" name="expire_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd'})" readonly="readonly" value="{{$expire_time}}">
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