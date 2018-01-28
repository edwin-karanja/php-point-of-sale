<button type="submit" class="btn btn-{{ $type or 'primary'}}">
    @if ($slot == 'Add')
        <i class="fa fa-plus"></i>
    @else
        <i class="fa fa-pencil-square-o"></i>
    @endif
    {{ $slot }} Category
</button>