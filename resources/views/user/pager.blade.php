{!! $Users->render() !!}

{!! $Users->count() !!}
{!! $Users->currentPage() !!}
{!! $Users->hasMorePages() !!}
{!! $Users->lastPage() !!}

{!! $Users->perPage() !!}
{!! $Users->previousPageUrl() !!}
{!! $Users->total() !!}
{{--{!! $Users->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($Users->previousPageUrl())
        <a class="icon item" href="{!! $Users->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $Users->count())

    @if($Users->nextPageUrl())
        <a class="icon item" href="{!! $Users->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>