<table class="ui celled center aligned table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('name') !!}">任务名称</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('keyword') !!}">关键词</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('url') !!}">链接</a>
        </th>
        <th>
            昨日PV
            /
            <a href="{!! $clsTaskIndex->getBaseLink('per_pv') !!}">今日PV</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('user_id') !!}">用户</a>
        </th>

        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('enter_type') !!}">进入类型</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('start_time') !!}">开始日期</a>
            <a href="{!! $clsTaskIndex->getBaseLink('end_time') !!}">结束日期</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('state') !!}">状态</a>
        </th>
        <th>
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $a)
    <tr>
        <td>{{$a->name}}</td>
        <td>{{$a->keyword}}</td>
        <td>{{$a->url}}</td>
        <td>
            {{$a->yesterday_finish_count}}
            /
            {{$a->per_pv}}
        </td>
        <td>{{$a->user_name}}</td>

        <td>{{$a->enter_type_text()}}</td>

        <td>
            {{$a->start_time_short()}}<br />
            {{$a->end_time_short()}}
        </td>
        <td>{{$a->created_at}}</td>
        <td>
            @if($a->is_can_not_edit())
                {{$a->state_text()}}
            @else
                {!! Form::select(
                'state',
                $a->enabled_states(),
                $a->state,
                array('class'=>'ui fluid normal dropdown','task_id'=> $a->id))
                !!}
            @endif
        </td>
        <td>
            <a href="/task/{{$a->id}}/copy" target="_blank">复制</a>
            /
            <a href="/task/{{$a->id}}/edit" target="_blank">编辑</a>
             /
            <a href="/task/{{$a->id}}" target="_blank">日志</a>
            /
            <a href="/task/{{$a->id}}/collect" target="_blank">汇总</a>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="10">
            {!! $tasks->render() !!}
        </th>
    </tr>
    </tfoot>
</table>