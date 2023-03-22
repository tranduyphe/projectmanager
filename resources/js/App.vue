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
    <div v-else-if="
        $route.path == '/layoutview'
    ">
        <layoutview />
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
    import layouthtml from './components/layouts/Layout.vue'; 
    import layoutview from './components/layouts/LayoutView.vue'; 
    export default {
        components:{
            login,
            admin,
            register,
            dashboard,
            layouthtml,
            layoutview
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
        created: () => {
            document.body.removeAttribute("data-layout", "horizontal");
            document.body.removeAttribute("data-topbar", "dark");
            document.body.setAttribute("data-sidebar", "dark");
        },
        mounted() {
            // document.body.classList.remove("auth-body-bg");
            // if (this.loader === true) {
            // document.getElementById("preloader").style.display = "block";
            // document.getElementById("status").style.display = "block";

            // setTimeout(function () {
            //     document.getElementById("preloader").style.display = "none";
            //     document.getElementById("status").style.display = "none";
            // }, 2500);
            // } else {
            //     document.getElementById("preloader").style.display = "none";
            //     document.getElementById("status").style.display = "none";
            // }
            // console.log(this.loginResponse)
            // console.log(this.authUser.roles)
            // console.log(this.loginResponse.authenticated)
        }
    }
</script>
