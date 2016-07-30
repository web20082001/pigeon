{!! Form::open(array('action' => array('TaskController@update',$id),'class'=>'ui form')) !!}

<div class="field">
    <label>任务名称</label>
    <input type="text" name="name" value="{{$task->name}}">
</div>

<div class="field">
    <label>关键词</label>
    <input type="text" name="keyword" value="{{$task->keyword}}">
</div>

<div class="field">
    <label>链接</label>
    <input type="text" name="url" value="{{$task->url}}">
</div>

<div class="field">
    <h4 class="ui header">状态</h4>
    {!! Form::select(
        'state',
        Lang::get('models.task.state'),
        $task->state,
        array('class'=>'ui fluid normal dropdown'))
    !!}
</div>

<div class="field">
    <h4 class="ui header">进入类型</h4>
    {!! Form::select(
        'enter_type',
        Lang::get('models.task.enter_type'),
        $task->enter_type,
        array('class'=>'ui fluid normal dropdown'))
    !!}
</div>

<div class="field">
    <label>日PV</label>
    <input type="text" name="per_pv" value="{{$task->per_pv}}">
</div>

<div class="field">
    <label>日PV分布</label>
    <input type="text" name="per_pv_spread" value="{{$task->per_pv_spread}}">
</div>

<div class="field">
    <label>开始日期</label>
    <input type="text" name="start_time" value="{{$task->start_time}}">
</div>

<div class="field">
    <label>结束日期</label>
    <input type="text" name="end_time" value="{{$task->end_time}}">
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('添加',['class'=>'ui button']) !!}

{!! Form::close() !!}