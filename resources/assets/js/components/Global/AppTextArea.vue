<template>
    <textarea
        v-bind="$attrs"
        :name="name"
        :id="name"
        class="form-control"
        :value="value"
        :rows="rows"
        @input="$emit('input', $event.target.value)"
    >
    </textarea>
</template>

<script>
    export default {
        props: {
            value: {
                default: '',
                required: false,
                type: String
            },
            name: {
                required: true,
                type: String
            }
        },

        computed: {
            rows () {
                return Math.max(2, this.value ? this.value.split("\n").length : 1)
            }
        }
    }
</script>