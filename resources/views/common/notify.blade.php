@if (count($errors) > 0)
    <div class="ui error message">
        <div class="header"></div>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (session('success'))
    <div class="ui success message">
        {{ session('success') }}
        @if (count(session('data')))
            @foreach (session('data')['success_msgs'] as $m)
                <p>{{ $m }}</p>
            @endforeach
        @endif
    </div>
@endif

@if (session('error'))
    <div class="ui error message">
        {{ session('error') }}
        @if (count(session('data')))
                @foreach (session('data')['error_msgs'] as $m)
                    <p>{{ $m }}</p>
                @endforeach
        @endif
    </div>
@endif