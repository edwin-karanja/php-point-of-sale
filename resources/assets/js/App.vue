<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <div class="list-group">
                    <router-link class="list-group-item list-group-item-action" :class="{ 'active': $route.name === 'products' }" :to="{ name: 'products' }">Products</router-link>
                    <router-link class="list-group-item list-group-item-action" :class="{ 'active': $route.name === 'categories' }" :to="{ path: '' }">Categories</router-link>
                    <router-link class="list-group-item list-group-item-action" :class="{ 'active': $route.name === 'purchases' }" :to="{ path: '' }">Purchases</router-link>
                </div>
            </div>
            <div class="col-sm-10">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>