{!! Form::open(array('action' => array('AreaController@update',$id),'class'=>'ui form')) !!}

<div class="field">
    <label>所属上级</label>
    {{$parent_name}}
    <input type="hidden" name="parent_id" value="{{$area->parent_id}}">
</div>
<div class="field">
    <label>地区名称</label>
    <input type="text" name="name" value="{{$area->name}}">
</div>
<div class="field">
    <label>地区编号</label>
    <input type="text" name="code" value="{{$area->code}}">
</div>
<div class="field">
    <label>排序</label>
    <input type="text" name="order_sort" value="{{$area->order_sort}}">
</div>
<div class="inline fields">
    <label for="fruit">状态</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if(!$area->disabled_at) checked="checked" @endif class="hidden" value="0">
            <label>启用</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="disabled_at" @if($area->disabled_at) checked="checked" @endif class="hidden" value="1">
            <label>禁用</label>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
{!! Form::submit('保存',['class'=>'ui button']) !!}

{!! Form::close() !!}