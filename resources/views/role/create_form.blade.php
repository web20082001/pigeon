{!! Form::open(array('action' => array('RoleController@store'),'class'=>'ui form')) !!}

    <div class="field">
        <label>名称</label>
        <input type="text" name="name">
    </div>

    <div class="field">
        <label>权限描述</label>
        <input type="text" name="memo" value="">
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
    {!! Form::submit('添加',['class'=>'ui button']) !!}

{!! Form::close() !!}