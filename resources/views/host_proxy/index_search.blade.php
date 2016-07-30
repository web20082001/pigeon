{!! Form::open(array('action' => array('HostProxyController@index'), 'method'=>'get')) !!}

    <h4 class="ui header">地区</h4>
    <select name="area_id" class="ui fluid normal dropdown">
        <option value="-1">请选择</option>
        @foreach ($areas as $a)
            <option value="{{$a->id}}" @if($a->id == $clsHostProxyIndex->getAreaId()) selected @endif>{{$a->name}}</option>
        @endforeach
    </select>


    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        array(''=>'请选择') + Lang::get('search.host_proxy'),
        $clsHostProxyIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}




    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsHostProxyIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/host_proxy/create">新增</a>

{!! Form::close() !!}
