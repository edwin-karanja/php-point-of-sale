<template>
    <input
        :type="type"
        class="form-control"
        :placeholder="placeholder | capitalize"
        @input=updateValue
        @keyup.esc="clear"
        @keyup.enter="enter"
        v-model="value"
    />
</template>

<script>
export default {
    props: {
        type: {
            default: 'text',
            required: false,
            type: String
        },
        placeholder: {
            required: false,
            type: String,
            default: ''
        }
    },

    data () {
        return {
            value: ''
        }
    },

    methods: {
        updateValue (e) {
            this.$emit('input', e.target.value)
        },

        clear () {
            this.value = '';
            this.$emit('input', '');
            this.$emit('clear');
        },

        enter () {
            this.$emit('enter');
        }
    },

    filters: {
            capitalize: function (value) {
                if (!value) return '';

                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        },
}
</script>