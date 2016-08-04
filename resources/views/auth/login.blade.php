<!-- resources/views/auth/login.blade.php -->
<script type="text/javascript" src="{{ asset('js/jquery-3.1.0.js',getenv('HTTP_SECURE')) }}"></script>



<div style="text-align: center;">

<form method="POST" action="/auth/login">
    {!! csrf_field() !!}
    <div>
        邮箱
        <input type="text" name="email" placeholder="邮箱" value="{{ old('email') }}">

    </div>

    <div>
        密码
        <input type="password" name="password" id="password">
    </div>

    <div>

        <label><input type="checkbox" name="remember">记住我</label>

        @if (count($errors))
            <ul>
                @foreach($errors->all() as $error)
                    <li style="color: red; font-size: 12px;list-style: none;">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    </div>

    <div>
        <button type="submit">登录</button>
    </div>
</form>

</div>
<script type="text/javascript">
    $(function () {
        $('input[name="email"]').focus();
    });
</script> 