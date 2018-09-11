<template>
    <div class="">
        <AppTable endpoint="/admin/items" resource="items"></AppTable>
    </div>
</template>

<script>
    import AppTable from '../../../components/Global/AppTable';

    export default {
        components: {
            AppTable
        }
    }
</script>