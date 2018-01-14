<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="{{ return_if(on_page('dashboard'), 'active') }}">
                <a href="/dashboard">@svg('icon-dashboard') Dashboard</a>
            </li>
            <hr>
            <li class="{{ return_if(on_page('categories'), 'active') }}">
                <a href="/categories">@svg('icon-tag') Categories</a>
            </li>
            <li class="{{ return_if(on_page('items'), 'active') }}">
                <a href="/items">@svg('icon-briefcase') Stock Items</a>
            </li>
            <li class="{{ return_if(on_page('inventory'), 'active') }}">
                <a href="/inventory">@svg('icon-trending-up') Manage Inventory</a>
            </li>
            <hr>
            <li class="{{ return_if(on_page('customers'), 'active') }}">
                <a href="/customers">@svg('icon-user') Customers</a>
            </li>
            <li class="{{ return_if(on_page('suppliers'), 'active') }}">
                <a href="/suppliers">@svg('icon-user') Suppliers</a>
            </li>
            <hr>
            <li class="{{ return_if(on_page('sales'), 'active') }}">
                <a href="/sales">@svg('icon-cart') Sales</a>
            </li>
            <li class="{{ return_if(on_page('purchases'), 'active') }}">
                <a href="/purchases">@svg('icon-globe') Purchases</a>
            </li>
            <hr>
            <li class="{{ return_if(on_page('settings'), 'active') }}">
                <a href="/settings">@svg('icon-cog') Settings</a>
            </li>
        </ul>
    </div>

    <div class="panel-footer">
        POS Navigation
    </div>
</div>
