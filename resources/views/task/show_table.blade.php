<table class="ui celled center aligned table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('id') !!}">订单编号</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('expect_time') !!}">预计时间</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('start_time') !!}">开始时间</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('end_time') !!}">完成时间</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('addr') !!}">IP地址</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('area_id') !!}">主机地区</a>
        </th>
        <th>
            <a href="{!! $clsTaskLogIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($task_logs as $t)
    <tr>
        <td>{{$t->id}}</td>
        <td>{{$t->expect_time}}</td>
        <td>{{$t->start_time}}</td>
        <td>{{$t->end_time}}</td>
        <td>{{$t->addr}}</td>
        <td>{{$t->area_name}}</td>
        <td>{{$t->created_at}}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="10">
            {!! $task_logs->render() !!}
        </th>
    </tr>
    </tfoot>
</table>