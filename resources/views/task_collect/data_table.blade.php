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
        <th>
            完成率
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($taskCollects as $c)
    <tr>
        <td>
            {{$c->collect_date}}
        </td>
        <td>
            {{$c->per_pv}}
        </td>
        <td>
            {{$c->finish_count}}
        </td>
        <td>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>