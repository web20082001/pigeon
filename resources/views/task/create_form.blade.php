{!! Form::open(array('action' => array('TaskController@store'),'class'=>'ui form')) !!}

    <div class="field">
        <label>任务名称</label>
        <input type="text" name="name" value="{{old('name')}}">
    </div>

    <div class="field">
        <label>关键词</label>
        <input type="text" name="keyword" value="{{old('keyword')}}">
    </div>

    <div class="field">
        <label>链接</label>
        <input type="text" name="url" value="{{old('url')}}">
    </div>


    <div class="field">
        <h4 class="ui header">进入类型</h4>
        {!! Form::select(
            'enter_type',
            Lang::get('models.task.enter_type'),
            1,
            array('class'=>'ui fluid normal dropdown'))
        !!}
    </div>

    <div class="field">
        <label>日PV</label>
        <input type="text" name="per_pv" value="{{old('per_pv')}}">
    </div>


    <div class="field">
        <label>开始日期</label>
        <input type="text" class="Wdate" id="begin" name="start_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'end\');}',minDate:'#F{$dp.$D(\'end\',{d:-7});}'})" readonly="readonly" value="{{$start_time}}">
    </div>

    <div class="field">
        <label>结束日期</label>
        <input type="text" class="Wdate" id="end" name="end_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'begin\');}',maxDate:'#F{$dp.$D(\'begin\',{d:7});}'})" readonly="readonly" value="{{$end_time}}">
    </div>


<div class="field">
    <h4 class="ui header">操作</h4>
    {!! Form::select(
        'state',
        Lang::get('models.task.state_create'),
        2,
        array('class'=>'ui fluid normal dropdown'))
    !!}
</div>


    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::submit('添加',['class'=>'ui primary button']) !!}

{!! Form::close() !!}
