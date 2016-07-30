{!! Form::open(array('action' => array('AreaController@index'), 'method'=>'get')) !!}

    <h4 class="ui header">状态</h4>
    {!! Form::select(
      'disabled_at',
      array('-1'=>'不限') + Lang::get('common.disabled_at'),
      $clsAreaIndex->getDisabledAt(),
      array('class'=>'ui fluid normal dropdown'))
    !!}



    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        Lang::get('search.area'),
        $clsAreaIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}




    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsAreaIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/area/create">新增</a>

{!! Form::close() !!}

