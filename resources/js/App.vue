<script>
import login from './components/account/Login.vue';
import loginLayout from './components/account/LoginLayout.vue';
import register from './components/account/Register.vue';
import dashboard from './components/layouts/Dashboard.vue';
import layouthtml from './components/layouts/Layout.vue';
import Header from "./components/layouts/Header.vue";
import Footer from "./components/layouts/Footer.vue";
import SideBar from "./components/layouts/SiderBar.vue";
export default {
    components: {
        login,
        loginLayout,
        register,
        dashboard,
        layouthtml,
        Header,
        Footer,
        SideBar
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

        roleUser() {
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
        //     document.getElementById("preloader").style.display = "block";
        //     document.getElementById("status").style.display = "block";

        setTimeout(function () {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        }, 2500);
        // } else {
        //     document.getElementById("preloader").style.display = "none";
        //     document.getElementById("status").style.display = "none";
        // }
    }
}
</script>
<template>
    <!-- <router-view></router-view> -->
    <div v-if="
        !loginResponse.authenticated
    ">
        <loginLayout />
    </div>
    <div v-else>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <i class="ri-loader-line spin-icon"></i>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <Header />
            <SideBar />
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <!-- <dashboard /> -->
                    <router-view />
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->
            <!-- <Footer /> -->
        </div>
        <!-- END layout-wrapper -->
    </div>
</template>