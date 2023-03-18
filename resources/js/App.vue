<template>
    <!-- <router-view></router-view> -->
    <div v-if="
        $route.path == '/' || $route.path == '/login'
    ">
        <login />
    </div>
    <div v-else-if="
        $route.path == '/layouthtml'
    ">
        <layouthtml />
    </div>
    <div style="" class="d-flex unauthorized" v-else-if="
        !loginResponse.authenticated">
        <login />
    </div>
    <div style="" class="d-flex unauthorized" v-else>
        <dashboard />
    </div>
</template>
<script> 
    import login from './components/account/Login.vue';
    import admin from './components/backend/Admin.vue';
    import register from './components/account/Register.vue';
    import dashboard from './components/layouts/Dashboard.vue';  
    import layouthtml from './components/layouts/Layout.vue' 
    export default {
        components:{
            login,
            admin,
            register,
            dashboard,
            layouthtml
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

            authUser() {
                if (this.$store.getters.getAuthUser.id !== undefined) {
                    return this.$store.getters.getAuthUser;
                }
                return JSON.parse(sessionStorage.getItem('authUser'));
            },

            roleUser(){
                if (this.$store.getters.getAuthUser.id !== undefined) {
                    return this.$store.getters.getAuthUser;
                }

                return this.authUser.roles[0]['name']; 
            }
        },
        mounted() {
            // console.log(this.loginResponse)
            // console.log(this.authUser.roles)
            // console.log(this.loginResponse.authenticated)
        }
    }
</script>
