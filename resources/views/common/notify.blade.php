@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        @if (count(session('data')))
        <ol>
            @foreach (session('data')['success_msgs'] as $m)
                <li>{{ $m }}</li>
            @endforeach
        </ol>
        @endif
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
        @if (count(session('data')))
            <ol>
                @foreach (session('data')['error_msgs'] as $m)
                    <li>{{ $m }}</li>
                @endforeach
            </ol>
        @endif
    </div>
@endif