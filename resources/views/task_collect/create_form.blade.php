{!! Form::open(array('action' => array('AreaController@store'),'class'=>'ui form')) !!}

    <div class="field">

            @if($parent_id > 0)
                <label>省</label>
                {{$parent_name}}
            @endif

        <input type="hidden" name="parent_id" value="{{$parent_id}}">
    </div>
    <div class="field">
        <label>

            <label>
            @if($parent_id == 0)
                省
            @else
                市
            @endif
            </label>

        </label>
        <input type="text" name="name" value="{{old('name')}}">
    </div>
    <div class="field">
        <label>编号</label>
        <input type="text" name="code" value="{{old('code')}}">
    </div>
    <div class="field">
        {{--<label>排序</label>--}}
        <input class="hidden" type="text" name="order_sort" value="{{$order_sort_max}}">
    </div>


    <div class="inline fields">
        <label for="fruit">状态</label>
        <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" name="disabled_at" checked="checked" class="hidden" value="0">
                <label>启用</label>
            </div>
        </div>
        <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" name="disabled_at" class="hidden" value="1">
                <label>禁用</label>
            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::submit('添加',['class'=>'ui primary button']) !!}

{!! Form::close() !!}