<table class="ui celled table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsHostProxyIndex->getBaseLink('area_id') !!}">地区</a>
        </th>
        <th>
            <a href="{!! $clsHostProxyIndex->getBaseLink('remote_addr') !!}">主机地址</a>
        </th>
        <th>
            <a href="{!! $clsHostProxyIndex->getBaseLink('addr') !!}">IP</a>
        </th>
        <th>
            <a href="{!! $clsHostProxyIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsHostProxyIndex->getBaseLink('updated_at') !!}">更新时间</a>
        </th>

    </tr>
    </thead>
    <tbody>
    @foreach ($host_proxys as $hp)
    <tr>
        <td>{{$hp->area_name}}</td>
        <td>{{$hp->remote_addr}}</td>
        <td>{{$hp->addr}}</td>
        <td>{{$hp->created_at}}</td>
        <td>{{$hp->updated_at}}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5">
            {!! $host_proxys->render() !!}
        </th>
    </tr>
    </tfoot>
</table>