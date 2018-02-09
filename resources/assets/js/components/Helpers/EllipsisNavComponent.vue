<template>
    <nav>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div id="icn">
                <i class="fa fa-bars"></i> Menu
            </div>
            </a>
            <ul class="dropdown-menu">
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
            </ul>
        </li>
    </nav>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
    li {
        list-style: none;
    }

    #icn {
        color: #515A5A;
    }
</style>
