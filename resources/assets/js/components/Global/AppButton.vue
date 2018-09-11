<template>
    <a
        @click="clicked"
        class="btn"
        :class="[
            themes[theme], sizes[size], {
                'disabled': disabled
            }
        ]"
        :type="type"
    >
        <slot> Button Name </slot>
    </a>
</template>

<script>
 export default {
     props: {
         theme: {
             required: false,
             type: String,
             default: 'default'
         },

         size: {
             required: false,
             type: String,
             default: 'normal'
         },

         disabled: {
             type: Boolean,
             required: false,
             default: false
         },

         type: {
             type: String,
             required: false,
             default: 'button'
         }
     },

     data () {
         return {
             themes: {
                 default: 'btn-default',
                 success: 'btn-success',
                 danger: 'btn-danger',
                 primary: 'btn-primary',
                 link: 'btn-link'
             },

             sizes: {
                 extraSmall: 'btn-xs',
                 small: 'btn-sm',
                 large: 'btn-lg',
                 normal: ''
             }
         };
     },

     methods: {
        clicked (e) {

            if (this.disabled) {
                return
            }

            this.$emit('click', e)
        }
    }
 }
</script>