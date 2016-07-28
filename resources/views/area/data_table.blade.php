<table class="ui celled table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('name') !!}">名称</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('code') !!}">编号</a>
        </th>
        <th>
            <a href="{!! $clsAreaIndex->getBaseLink('order_sort') !!}">排序</a>
        </th>
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
        <td>{{$a->name}}</td>
        <td>{{$a->code}}</td>
        <td>{{$a->order_sort}}</td>
        <td>{{$a->disabled_at_text()}}</td>
        <td>{{$a->created_at}}</td>
        <td>{{$a->updated_at}}</td>
        <td>


            {!! Form::open(array('action' => array('AreaController@destroy', $a->id), 'method'=>'post')) !!}
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="ui primary button">删除</button>
            </form>
            {!! Form::close() !!}


            {!! Form::open(array('action' => array('AreaController@edit', $a->id), 'method'=>'get')) !!}
            <button type="submit" class="ui primary button">编辑</button>
            </form>
            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7">
            {!! $areas->render() !!}
        </th>
    </tr>
    </tfoot>
</table>