{!! $areas->render() !!}

{!! $areas->count() !!}
{!! $areas->currentPage() !!}
{!! $areas->hasMorePages() !!}
{!! $areas->lastPage() !!}

{!! $areas->perPage() !!}
{!! $areas->previousPageUrl() !!}
{!! $areas->total() !!}
{{--{!! $areas->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($areas->previousPageUrl())
        <a class="icon item" href="{!! $areas->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $areas->count())

    @if($areas->nextPageUrl())
        <a class="icon item" href="{!! $areas->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>