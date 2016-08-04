<table class="ui celled center aligned table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsTaskCollectIndex->getBaseLink('collect_date') !!}">日期</a>
        </th>
        <th>
            <a href="{!! $clsTaskCollectIndex->getBaseLink('per_pv') !!}">预设日PV</a>
        </th>
        <th>
            <a href="{!! $clsTaskCollectIndex->getBaseLink('finish_count') !!}">完成量</a>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($taskCollects as $t)
    <tr>
        <td>{{$t->collect_date}}</td>
        <td>{{$t->per_pv}}</td>
        <td>{{$t->finish_count}}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="10">
            {!! $taskCollects->render() !!}
        </th>
    </tr>
    </tfoot>
</table>