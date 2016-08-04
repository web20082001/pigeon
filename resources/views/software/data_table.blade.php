<table class="ui celled center aligned table">
    <thead>
    <tr>

        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('name') !!}">名称</a>
        </th>
        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('code') !!}">代号</a>
        </th>
        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('version') !!}">版本</a>
        </th>

        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('url') !!}">下载地址</a>
        </th>
        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsSoftwareIndex->getBaseLink('updated_at') !!}">更新时间</a>
        </th>
        <th>
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($softwares as $s)
    <tr>

        <td>{{$s->name}}</td>
        <td>{{$s->code}}</td>
        <td>{{$s->version}}</td>
        <td>{{$s->url}}</td>
        <td>{{$s->created_at}}</td>
        <td>{{$s->updated_at}}</td>
        <td>
            {!! Form::open(array('action' => array('SoftwareController@destroy', $s->id), 'method'=>'post')) !!}
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="hidden">删除</button>

                {{--<a class="delete">删除</a>--}}
                {{--/--}}
                <a href="/software/{{$s->id}}/edit" target="_blank">编辑</a>
            </form>
            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="8">
            {!! $softwares->render() !!}
        </th>
    </tr>
    </tfoot>
</table>