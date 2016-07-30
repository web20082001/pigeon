<table class="ui celled table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsHostIndex->getBaseLink('area_id') !!}">地区</a>
        </th>
        <th>
            <a href="{!! $clsHostIndex->getBaseLink('remote_addr') !!}">主机地址</a>
        </th>
        <th>
            <a href="{!! $clsHostIndex->getBaseLink('disabled_at') !!}">状态</a>
        </th>
        <th>
            <a href="{!! $clsHostIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsHostIndex->getBaseLink('updated_at') !!}">更新时间</a>
        </th>
        <th>
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($hosts as $a)
    <tr>
        <td>{{$a->area_name}}</td>
        <td>{{$a->remote_addr}}</td>
        <td>{{$a->disabled_at_text()}}</td>
        <td>{{$a->created_at}}</td>
        <td>{{$a->updated_at}}</td>
        <td>


            {!! Form::open(array('action' => array('HostController@destroy', $a->id), 'method'=>'post')) !!}
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="ui primary button">删除</button>
            </form>
            {!! Form::close() !!}

            <a href="/host/{{$a->id}}/edit">编辑</a>

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7">
            {!! $hosts->render() !!}
        </th>
    </tr>
    </tfoot>
</table>