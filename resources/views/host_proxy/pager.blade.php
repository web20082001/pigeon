{!! $host_proxys->render() !!}

{!! $host_proxys->count() !!}
{!! $host_proxys->currentPage() !!}
{!! $host_proxys->hasMorePages() !!}
{!! $host_proxys->lastPage() !!}

{!! $host_proxys->perPage() !!}
{!! $host_proxys->previousPageUrl() !!}
{!! $host_proxys->total() !!}
{{--{!! $host_proxys->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($host_proxys->previousPageUrl())
        <a class="icon item" href="{!! $host_proxys->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $host_proxys->count())

    @if($host_proxys->nextPageUrl())
        <a class="icon item" href="{!! $host_proxys->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>