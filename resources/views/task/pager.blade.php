{!! $tasks->render() !!}

{!! $tasks->count() !!}
{!! $tasks->currentPage() !!}
{!! $tasks->hasMorePages() !!}
{!! $tasks->lastPage() !!}

{!! $tasks->perPage() !!}
{!! $tasks->previousPageUrl() !!}
{!! $tasks->total() !!}
{{--{!! $tasks->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($tasks->previousPageUrl())
        <a class="icon item" href="{!! $tasks->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $tasks->count())

    @if($tasks->nextPageUrl())
        <a class="icon item" href="{!! $tasks->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>