<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ isset($company) ? $company->name : config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    @if (auth()->check())
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                        &nbsp;<li class="{{ return_if(on_page('dashboard'), 'active') }}">
                            <a href="/dashboard">@svg('icon-dashboard') Dashboard</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                @svg('icon-briefcase')
                                 Stocks <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/items">@svg('icon-briefcase') Stock Items</a>
                                </li>
                                <li>
                                    <a href="/inventory">@svg('icon-trending-up') Manage Inventory</a>
                                </li>
                                <li>
                                    <a href="/categories">@svg('icon-tag') Categories</a>
                                </li>
                            </ul>
                        </li>


                        @if (config('pos.modules.customers'))
                            <li class="{{ return_if(on_page('customers'), 'active') }}">
                                <a href="/customers">@svg('icon-user') Customers</a>
                            </li>
                        @endif

                        @if (config('pos.modules.suppliers'))
                            <li class="{{ return_if(on_page('suppliers'), 'active') }}">
                                <a href="/suppliers">@svg('icon-user') Suppliers</a>
                            </li>
                        @endif

                        @if (config('pos.modules.sales'))
                            <li class="{{ return_if(on_page('sales'), 'active') }}">
                                <a href="/sales">@svg('icon-cart') Sales</a>
                            </li>
                        @endif

                        @if (config('pos.modules.purchases'))
                            <li class="{{ return_if(on_page('purchases'), 'active') }}">
                                <a href="/purchases">@svg('icon-globe') Purchases</a>
                            </li>
                        @endif

                        @if (config('pos.modules.reports'))
                            <li class="{{ return_if(on_page('reports'), 'active') }}">
                                <a href="/reports">@svg('icon-trending-up') Reports</a>
                            </li>
                        @endif

                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li class="{{ return_if(on_page('settings'), 'active') }}">
                                        <a href="/settings/store">@svg('icon-cog') Settings</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>