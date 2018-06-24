<template>
    <div class="hidden">
        Page refresh component
    </div>
</template>

<script>
    export default {
        data () {
            return {
                durationInMinutes: 15
            };
        },

        methods: {
            keepTokenAlive () {
                axios.post('/keep-token-alive').then((response) => {
                    console.log('kept alive..') //@TODO remove this on going to production
                }).catch((error) => {
                    location.replace('/login');
                })
            }
        },

        mounted() {
            setInterval(() => {
                this.keepTokenAlive()
            }, 1000 * 60 * this.durationInMinutes)
        }
    }
</script>

<style scoped>
    .hidden {
        display: none;
    }
</style>
