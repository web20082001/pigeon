{!! Form::open(array('action' => array('TaskController@index'), 'method'=>'get')) !!}


    <h4 class="ui header">状态</h4>
    {!! Form::select(
        'state',
        array('-1'=>'不限') + Lang::get('models.task.state'),
        $clsTaskIndex->getState(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">进入类型</h4>
    {!! Form::select(
        'enter_type',
        array('-1'=>'不限') + Lang::get('models.task.enter_type'),
        $clsTaskIndex->getEnterType(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        array(''=>'请选择') + Lang::get('search.task'),
        $clsTaskIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}

    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsTaskIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/task/create">新增</a>

{!! Form::close() !!}

