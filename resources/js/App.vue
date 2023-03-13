<template>
    <!-- <router-view></router-view> -->
    <div v-if="$route.path == '/'">
        <login />
    </div>
    <div style="" class="d-flex unauthorized" v-else>
        <admin />
    </div>
</template>
<script> 
    import login from './components/account/Login.vue';
    import admin from './components/backend/Admin.vue';
    export default {
        components:{
            login,
            admin
        },
        computed: {
            loginResponse() {
                let output = undefined;

                if (
                    this.$store.getters.getLoginResponse.authenticated !==
                        undefined &&
                    output == undefined
                ) {
                    output = this.$store.getters.getLoginResponse;
                }

                if (
                    JSON.parse(sessionStorage.getItem('loginResponse')) !==
                        undefined &&
                    output == undefined
                ) {
                    output = JSON.parse(sessionStorage.getItem('loginResponse'));
                }

                if (output == undefined) {
                    output = {
                        authenticated: false,
                    };
                }
                return output;
            },

            // authUser() {
            //     if (this.$store.getters.getAuthUser.id !== undefined) {
            //         return this.$store.getters.getAuthUser;
            //     }
            //     return JSON.parse(sessionStorage.getItem('authUser'));
            // },
        },
        mounted() {
            console.log(this.loginResponse)
        }
    }
</script>
