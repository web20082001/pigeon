{!! Form::open(array('action' => array('UserController@index'), 'method'=>'get')) !!}

<form class="ui form">


    <h4 class="ui header">状态</h4>
    {!! Form::select(
      'disabled_at',
      array('-1'=>'不限') + Lang::get('common.disabled_at'),
      $clsUserIndex->getDisabledAt(),
      array('class'=>'ui fluid normal dropdown'))
    !!}



    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        Lang::get('search.User'),
        $clsUserIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}




    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsUserIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

</form>
{!! Form::close() !!}