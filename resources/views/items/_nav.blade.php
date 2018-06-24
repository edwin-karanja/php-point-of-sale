<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="{{ return_if(on_page('items/' .$item->id.'/edit'), 'active') }}">
                <a href="/items/{{ $item->id }}/edit">
                    Item Properties
                </a>
            </li>
            <li class="{{ return_if(on_page('items/' .$item->id.'/audit'), 'active') }}">
                <a href="/items/{{ $item->id }}/audit">
                    Item Audits
                </a>
            </li>
            <li class="{{ return_if(on_page('items/' .$item->id.'/suppliers'), 'active') }}">
                <a href="/items/{{ $item->id }}/suppliers">
                    Item Suppliers
                </a>
            </li>
        </ul>
    </div>
    <div class="panel-footer">
        {{ ucwords( $item->name ) }}
    </div>
</div>