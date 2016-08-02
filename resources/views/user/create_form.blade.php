{!! Form::open(array('action' => array('UserController@store'),'class'=>'ui form')) !!}

    <div class="field">
        <label>用户名</label>
        <input type="text" name="name" value="{{old('name')}}">
    </div>
    <div class="field">
        <label>密码</label>
        <input type="password" name="password">
    </div>

    <div class="field">
        <label>真实姓名</label>
        <input type="text" name="realname" value="{{old('realname')}}">
    </div>

    <div class="field">
        <label>邮箱</label>
        <input type="text" name="email" value="{{old('email')}}">
    </div>

    <div class="field">
    <h4 class="ui header">权限</h4>
    <select name="role_id" class="ui fluid normal dropdown">
        <option value="">请选择</option>
        @foreach ($roles as $r)
            <option value="{{$r->id}}">{{$r->name}}</option>
        @endforeach
    </select>
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