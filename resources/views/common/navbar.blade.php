<div class="ui menu">
    {{--<div class="header item">--}}
        {{--<a href="/">首页</a>--}}
    {{--</div>--}}

    <a class="item @if(Route::current()->getPath() == 'task') active @endif" href="/task">
        任务管理
    </a>

    <a class="item @if(Route::current()->getPath() == 'host') active @endif" href="/host">
        主机管理
    </a>

    <a class="item @if(Route::current()->getPath() == 'host_proxy') active @endif" href="/host_proxy">
        代理管理
    </a>

    <a class="item @if(Route::current()->getPath() == 'area') active @endif" href="/area">
        地区管理
    </a>

    <a class="item @if(Route::current()->getPath() == 'user') active @endif" href="/user">
        用户管理
    </a>

    <a class="item @if(Route::current()->getPath() == 'role') active @endif" href="/role">
        权限管理
    </a>


    {{--<div class="ui dropdown item" tabindex="0">--}}
        {{--Dropdown--}}
        {{--<i class="dropdown icon"></i>--}}
        {{--<div class="menu transition hidden" tabindex="-1">--}}
            {{--<div class="item">Action</div>--}}
            {{--<div class="item">Another Action</div>--}}
            {{--<div class="item">Something else here</div>--}}
            {{--<div class="divider"></div>--}}
            {{--<div class="item">Separated Link</div>--}}
            {{--<div class="divider"></div>--}}
            {{--<div class="item">One more separated link</div>--}}
        {{--</div>--}}
    {{--</div>--}}




    <div class="right menu">
        {{--<div class="item">--}}
            {{--<div class="ui action left icon input">--}}
                {{--<i class="search icon"></i>--}}
                {{--<input type="text" placeholder="Search">--}}
                {{--<button class="ui button">Submit</button>--}}
            {{--</div>--}}
        {{--</div>--}}



        <a class="item active">{{Auth::user()->name }}</a>

        <a class="item active" href="/auth/logout">退出</a>
    </div>




</div>