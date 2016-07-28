{!! $hosts->render() !!}

{!! $hosts->count() !!}
{!! $hosts->currentPage() !!}
{!! $hosts->hasMorePages() !!}
{!! $hosts->lastPage() !!}

{!! $hosts->perPage() !!}
{!! $hosts->previousPageUrl() !!}
{!! $hosts->total() !!}
{{--{!! $hosts->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($hosts->previousPageUrl())
        <a class="icon item" href="{!! $hosts->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $hosts->count())

    @if($hosts->nextPageUrl())
        <a class="icon item" href="{!! $hosts->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>