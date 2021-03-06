{!! Form::open(array('action' => array('HostController@index'), 'method'=>'get','class'=>'ui form')) !!}




    <h4 class="ui header">城市</h4>
    <select name="area_id" class="ui fluid normal dropdown">
        <option value="-1">不限</option>
        @foreach ($areas as $a)
            <option value="{{$a->id}}" @if($a->id == $clsHostIndex->getAreaId()) selected @endif>{{$a->name}}</option>
        @endforeach
    </select>



    <h4 class="ui header">状态</h4>
    {!! Form::select(
      'disabled_at',
      array('-1'=>'不限') + Lang::get('common.disabled_at'),
      $clsHostIndex->getDisabledAt(),
      array('class'=>'ui fluid normal dropdown'))
    !!}



    <h4 class="ui header">查询条件</h4>
    {!! Form::select(
        'search',
        array(''=>'请选择') + Lang::get('search.host'),
        $clsHostIndex->getSearch(),
        array('class'=>'ui fluid normal dropdown'))
    !!}




    <h4 class="ui header">关键词</h4>
    <div class="ui input">
        <input type="text" name="keywords" placeholder="关键词" value="{{$clsHostIndex->getKeywords()}}">
    </div>


    {!! Form::submit('查询',['class'=>'ui primary button','id'=>'btnSearch']) !!}

    <a href="/host/create">新增</a>

{!! Form::close() !!}
