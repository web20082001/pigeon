{!! Form::open(array('action' => array('SoftwareController@store'),'class'=>'ui form')) !!}


    <div class="field">
        <label>名称</label>
        <input type="text" name="name" value="{{old('name')}}">
    </div>
    <div class="field">
        <label>代号</label>
        <input type="text" name="code" value="{{old('code')}}">
    </div>
    <div class="field">
        <label>版本</label>
        <input type="text" name="version" value="{{old('version')}}">
    </div>

    <div class="field">
        <label>下载地址</label>
        <input type="text" name="url" value="{{old('url')}}">
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::submit('添加',['class'=>'ui primary button']) !!}

{!! Form::close() !!}