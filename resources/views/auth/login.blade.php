<!-- resources/views/auth/login.blade.php -->

@if (count($errors))
    <ul>
        @foreach($errors->all() as $error)
            <li style="color: red; font-size: 12px">{{ $error }}</li>
        @endforeach
    </ul>
@endif

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
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>