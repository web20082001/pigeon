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
            <a href="{!! $clsTaskIndex->getBaseLink('per_pv') !!}">日PV</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('user_id') !!}">用户</a>
        </th>
        <th>
            <a href="{!! $clsTaskIndex->getBaseLink('state') !!}">状态</a>
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
        <td>{{$a->per_pv}}</td>
        <td>{{$a->user_name}}</td>
        <td>{{$a->state_text()}}</td>
        <td>{{$a->enter_type_text()}}</td>

        <td>
            {{$a->start_time}}<br />
            {{$a->end_time}}
        </td>
        <td>{{$a->created_at}}</td>
        <td>
            <a href="/task/{{$a->id}}/edit">编辑</a>
             /
            <a href="/task/{{$a->id}}">详情</a>
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