<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="{{ return_if(on_page('settings/profile'), 'active') }}">
                <a href="/settings/profile">
                    <i class="fa fa-cog"></i>
                    User Profile
                </a>
            </li>

            {{-- Employee Settings such as creating and deleting --}}
            @if (auth()->user()->isAdmin())
                <li class="{{ return_if(on_page('settings/users'), 'active') }}">
                    <a href="/settings/users">
                        <i class="fa fa-users"></i>
                        Users
                    </a>
                </li>
            @endif

            {{-- Store Settings --}}
            <li class="{{ return_if(on_page('settings/store'), 'active') }}">
                <a href="/settings/store">
                    <i class="fa fa-bank"></i>
                    Configure Store
                </a>
            </li>

            {{-- Security Settings --}}
            <li class="{{ return_if(on_page('settings/change_password'), 'active') }}">
                <a href="/settings/change_password">
                    <i class="fa fa-bolt"></i>
                    Password
                </a>
            </li>


            @if (config('pos.modules.settings.roles_permissions'))
                {{-- Roles Settings --}}
                <li class="{{ return_if(on_page('settings/roles'), 'active') }}">
                    <a href="/settings/roles">
                        <i class="fa fa-cogs"></i>
                        Roles
                    </a>
                </li>

                {{-- Permissions Settings --}}
                <li class="{{ return_if(on_page('settings/permissions'), 'active') }}">
                    <a href="/settings/permissions">
                        <i class="fa fa-cogs"></i>
                        Permissions
                    </a>
                </li>
            @endif

        </ul>
    </div>

    <div class="panel-footer">
        Settings Navigation
    </div>
</div>
