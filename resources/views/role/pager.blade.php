{!! $roles->render() !!}

{!! $roles->count() !!}
{!! $roles->currentPage() !!}
{!! $roles->hasMorePages() !!}
{!! $roles->lastPage() !!}

{!! $roles->perPage() !!}
{!! $roles->previousPageUrl() !!}
{!! $roles->total() !!}
{{--{!! $roles->url($page) !!}--}}



<div class="ui right floated pagination menu">

    @if($roles->previousPageUrl())
        <a class="icon item" href="{!! $roles->previousPageUrl() !!}">
            <i class="left chevron icon"></i>
        </a>
    @endif

    <a class="item">1</a>
    <a class="item">2</a>
    <a class="item">3</a>
    <a class="item">4</a>

        @foreach($i in $roles->count())

    @if($roles->nextPageUrl())
        <a class="icon item" href="{!! $roles->nextPageUrl() !!}">
            <i class="right chevron icon"></i>
        </a>
    @endif
</div>