<script>

import { mapGetters, mapMutations, mapActions } from 'vuex';

export default {
    data() {
        // return {
        //     languages: [
        //         {
        //             flag: require("@resources/assets/images/flags/us.jpg"),
        //             language: "en",
        //             title: "English"
        //         },
        //         {
        //             flag: require("@resources/assets/images/flags/french.jpg"),
        //             language: "fr",
        //             title: "French"
        //         },
        //         {
        //             flag: require("@resources/assets/images/flags/spain.jpg"),
        //             language: "es",
        //             title: "spanish"
        //         },
        //         {
        //             flag: require("@resources/assets/images/flags/chaina.png"),
        //             language: "zh",
        //             title: "Chinese"
        //         },
        //         {
        //             flag: require("@resources/assets/images/flags/arabic.png"),
        //             language: "ar",
        //             title: "Arabic"
        //         }
        //     ],
        //     current_language: "en"
        // };
    },
    // components: { simplebar },
    computed: {
        authUser() {
            if (this.$store.getters.getAuthUser.id !== undefined) {
                return this.$store.getters.getAuthUser;
            }
            return JSON.parse(sessionStorage.getItem('authUser'));
        }
    },
    methods: {
        ...mapActions(['logout']),
        toggleMenu() {
            // this.$parent.toggleMenu();
        },
    },
    mounted() {
        // console.log(this.loginResponse)
        // console.log(this.authUser);
        // console.log(this.loginResponse.authenticated)
    }
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="@resources/assets/images/logo-sm-dark.png" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@resources/assets/images/logo-dark.png" alt height="20" />
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="@resources/assets/images/logo-sm-light.png" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@resources/assets/images/logo-light.png" alt height="20" />
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" />
                        <span class="ri-search-line"></span>
                    </div>
                </form>             
            </div>
            <div class="d-flex">
                <div>
                    <h4 v-if="authUser">Welcome {{ authUser.name }}</h4>
                    <button class="btn btn-danger mb-2" @click="logout">
                        Logout
                    </button>
                </div>
                
            </div>
        </div>
    </header>
</template>

<style lang="scss" scoped>
.notify-item {
    .active {
        color: #16181b;
        background-color: #f8f9fa;
    }
}
</style>