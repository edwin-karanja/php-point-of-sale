<nav>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Home</a>
        </li>

        @foreach( request()->breadcrumbs()->segments() as $segment)
            <li class="breadcrumb-item">
                <a href="{{ $segment->url() }}">{{ optional( $segment->model())->name ?: $segment->name() }}</a>
            </li>
        @endforeach
    </ul>
</nav>