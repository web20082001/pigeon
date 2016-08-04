<table class="ui celled center aligned table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('parent_id') !!}">省</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('name') !!}">市</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('code') !!}">编号</a>
        </th>
        {{--<th>--}}
            {{--<a href="{!! $clsAreaIndex->getBaseLink('order_sort') !!}">排序</a>--}}
        {{--</th>--}}
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('disabled_at') !!}">状态</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('updated_at') !!}">更新时间</a>
        </th>
        <th>
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($areas as $a)
    <tr>
        <td>
            {{$a->parent_name}}
            @if($a->parent_id == 0)
                {{$a->name}}
            @endif
        </td>
        <td>
            @if($a->parent_id > 0)
            {{$a->name}}
            @endif
        </td>
        <td>{{$a->code}}</td>
        {{--<td>{{$a->order_sort}}</td>--}}
        <td>{!! $a->disabled_at_text()!!}</td>
        <td>{{$a->created_at}}</td>
        <td>{{$a->updated_at}}</td>
        <td>


            {!! Form::open(array('action' => array('AreaController@destroy', $a->id), 'method'=>'post')) !!}
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="hidden">删除</button>

                {{--<a class="delete">删除</a>--}}
                {{--/--}}
                <a href="/area/{{$a->id}}/edit">编辑</a>

                @if($a->parent_id == 0)
                    /
                    <a href="/area/create?parent_id={{$a->id}}">添加</a>
                @endif

            </form>
            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="8">
            {!! $areas->render() !!}
        </th>
    </tr>
    </tfoot>
</table>