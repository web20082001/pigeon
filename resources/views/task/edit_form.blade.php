{!! Form::open(array('action' => array('TaskController@update',$id),'class'=>'ui form')) !!}

<div class="field">
    <label>任务名称</label>
    <input type="text" name="name" value="{{$task->name}}">
</div>

<div class="field">
    <label>关键词</label>
    {{$task->keyword}}
</div>

<div class="field">
    <label>链接</label>
    {{$task->url}}
</div>



<div class="field">
    <h4 class="ui header">进入类型</h4>
    {!! Form::select(
        'enter_type',
        Lang::get('models.task.enter_type'),
        $task->enter_type,
        array('class'=>'ui fluid normal dropdown','disabled'=>'disabled'))
    !!}
</div>

<div class="field">
    <label>日PV</label>
    {{$task->per_pv}}
</div>

<div class="field">
    <label>开始日期</label>
    <input type="text" class="Wdate" id="begin" name="start_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'end\');}',minDate:'#F{$dp.$D(\'end\',{d:-7});}'})" disabled readonly="readonly" value="{{$task->start_time_short()}}">
</div>

<div class="field">
    <label>结束日期</label>
    <input type="text" class="Wdate" id="end" name="end_time" onclick="javascript:WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'begin\');}',maxDate:'#F{$dp.$D(\'begin\',{d:7});}'})" disabled readonly="readonly" value="{{$task->end_time_short()}}">
</div>

<div class="field">
    <h4 class="ui header">操作</h4>
    {!! Form::select(
        'state',
        $states,
        $task->state,
        array('class'=>'ui fluid normal dropdown'))
    !!}
</div>


<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(!$is_can_not_edit)
{!! Form::submit('保存',['class'=>'ui primary button']) !!}
@endif
{!! Form::close() !!}