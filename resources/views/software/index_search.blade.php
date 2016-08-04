{!! Form::open(array('action' => array('SoftwareController@index'), 'method'=>'get','class'=>'ui form')) !!}

    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        Lang::get('search.software'),
        $clsSoftwareIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsSoftwareIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/software/create">新增</a>

{!! Form::close() !!}

