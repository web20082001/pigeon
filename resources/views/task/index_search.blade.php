{!! Form::open(array('action' => array('TaskController@index'), 'method'=>'get','class'=>'ui form')) !!}

<div class="field">
    <label>开始日期</label>
    <input type="text" class="Wdate" id="begin" name="start_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'end\');}',minDate:'#F{$dp.$D(\'end\',{d:-7});}'})" readonly="readonly" value="{{$clsTaskIndex->getStartTime()}}">
</div>

<div class="field">
    <label>结束日期</label>
    <input type="text" class="Wdate" id="end" name="end_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'begin\');}',maxDate:'#F{$dp.$D(\'begin\',{d:7});}'})" readonly="readonly" value="{{$clsTaskIndex->getEndTime()}}">
</div>

    <h4 class="ui header">状态</h4>
    {!! Form::select(
        'state',
        array('-1'=>'不限') + Lang::get('models.task.state'),
        $clsTaskIndex->getState(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">进入类型</h4>
    {!! Form::select(
        'enter_type',
        array('-1'=>'不限') + Lang::get('models.task.enter_type'),
        $clsTaskIndex->getEnterType(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        array(''=>'请选择') + Lang::get('search.task'),
        $clsTaskIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsTaskIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/task/create">新增</a>

{!! Form::close() !!}

