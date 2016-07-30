{!! $users->render() !!}

{!! $users->count() !!}
{!! $users->currentPage() !!}
{!! $users->hasMorePages() !!}
{!! $users->lastPage() !!}

{!! $users->perPage() !!}
{!! $users->previousPageUrl() !!}
{!! $users->total() !!}
{{--{!! $users->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($users->previousPageUrl())
        <a class="icon item" href="{!! $users->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $users->count())

    @if($users->nextPageUrl())
        <a class="icon item" href="{!! $users->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>