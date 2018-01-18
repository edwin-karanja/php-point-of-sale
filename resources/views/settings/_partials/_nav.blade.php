<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="{{ return_if(on_page('settings/profile'), 'active') }}">
                <a href="/settings/profile">
                    <i class="fa fa-cog"></i>
                    Profile
                </a>
            </li>
            <li class="{{ return_if(on_page('settings/change_password'), 'active') }}">
                <a href="/settings/change_password">
                    <i class="fa fa-bolt"></i>
                    Change password
                </a>
            </li>
        </ul>
    </div>

    <div class="panel-footer">
        Settings Navigation
    </div>
</div>
