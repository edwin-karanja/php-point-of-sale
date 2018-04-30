<template>
    <nav class="navbar navbar-inverse">
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
                <a class="navbar-brand" href="#">
                    COMPANY
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;<li class="">
                        <router-link :to="{ name: 'dashboard' }"> Dashboard</router-link>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                Stocks <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"> Stock Items</a>
                            </li>
                            <li>
                                <a href="#"> Manage Inventory</a>
                            </li>
                            <li>
                                <a href="#"> Categories</a>
                            </li>
                        </ul>
                    </li>

                </ul>

                <ul class="nav navbar-nav navbar-right" v-if="!user.authenticated">
                    <li><router-link :to="{ name: 'login' }">Login</router-link></li>
                    <li><router-link :to="{ name: 'register' }">Register</router-link></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" v-if="user.authenticated">
                    <!-- Authentication Links -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ user.data.name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class=""><a href="#"> Settings</a></li>
                                <li class=""><a href="#">Logout</a></li>
                            </ul>
                        </li>
                    <!-- @endguest -->
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        computed: mapGetters({
            user: 'auth/user'
        })
    }
</script>