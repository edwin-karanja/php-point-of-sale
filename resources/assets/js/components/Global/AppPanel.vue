<template>
    <div class="panel panel-default">
        <slot name="header"></slot>


        <slot name="body"></slot>

        <slot name="footer"></slot>
    </div>
</template>

<script>
    export default {
        props: {

        }
    }
</script>