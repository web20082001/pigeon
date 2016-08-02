<table class="ui celled center aligned table">
    <thead>
    <tr>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('name') !!}">用户名</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('realname') !!}">真实姓名</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('email') !!}">邮箱</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('role_id') !!}">权限</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('disabled_at') !!}">状态</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('created_at') !!}">创建时间</a>
        </th>
        <th>
            <a href="{!! $clsUserIndex->getBaseLink('updated_at') !!}">更新时间</a>
        </th>
        <th>
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $a)
    <tr>
        <td>{{$a->name}}</td>
        <td>{{$a->realname}}</td>
        <td>{{$a->email}}</td>
        <td>{{$a->role_name}}</td>
        <td>{!! $a->disabled_at_text() !!}</td>
        <td>{{$a->created_at}}</td>
        <td>{{$a->updated_at}}</td>
        <td>

            {!! Form::open(array('action' => array('UserController@destroy', $a->id), 'method'=>'post')) !!}
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="hidden">删除</button>
                <a class="delete">删除</a>
                /
                <a href="/user/{{$a->id}}/edit">编辑</a>
            </form>
            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="8">
            {!! $users->render() !!}
        </th>
    </tr>
    </tfoot>
</table>