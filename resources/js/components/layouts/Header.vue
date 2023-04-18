<script>
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    data() {
        return {
            languages: [
                {
                    flag: require("@/assets/images/flags/us.jpg"),
                    language: "en",
                    title: "English",
                },
                {
                    flag: require("@/assets/images/flags/french.jpg"),
                    language: "fr",
                    title: "French",
                },
                {
                    flag: require("@/assets/images/flags/spain.jpg"),
                    language: "es",
                    title: "spanish",
                },
                {
                    flag: require("@/assets/images/flags/chaina.png"),
                    language: "zh",
                    title: "Chinese",
                },
                {
                    flag: require("@/assets/images/flags/arabic.png"),
                    language: "ar",
                    title: "Arabic",
                },
            ],
            current_language: "en",
        };
    },
    // components: { simplebar },
    computed: {
        ...mapGetters(["authUserData"]),
        authUser() {
            if (this.$store.getters.getAuthUser.id !== undefined) {
                return this.$store.getters.getAuthUser;
            }
            return JSON.parse(sessionStorage.getItem("authUser"));
        },
    },
    methods: {
        ...mapActions(["logout", "auth"]),
        toggleMenu() {
            // this.$parent.toggleMenu();
        },
    },
    create() {
        this.auth();
    },
    mounted() {
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.htms" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="@/assets/images/logo-sm-dark.png" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@/assets/images/logo-dark.png" alt height="20" />
                        </span>
                    </a>

                    <a href="index.htms" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="@/assets/images/logo.png" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@/assets/images/logo.png" alt height="20" />
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
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
                <b-dropdown variant="white" right toggle-class="header-item">
                    <template v-slot:button-content>
                        <img class src="@/assets/images/flags/us.jpg" alt="Header Language" height="16" />
                    </template>
                    <b-dropdown-item class="notify-item" v-for="(entry, i) in languages" :key="`Lang${i}`" :value="entry"
                        :link-class="{
                            active: entry.language === current_language,
                        }">
                        <img :src="`${entry.flag.default}`" alt="user-image" class="me-1" height="12" />
                        <span class="align-middle">{{ entry.title }}</span>
                    </b-dropdown-item>
                </b-dropdown>
                <b-dropdown right variant="black" toggle-class="header-item" class="d-inline-block user-dropdown">
                    <template v-slot:button-content>
                        <img class="rounded-circle header-profile-user" src="@/assets/images/users/avatar-2.jpg"
                            alt="Header Avatar" />
                        <span class="d-none d-xl-inline-block ms-1">
                            {{ authUserData.name }}
                        </span>
                    </template>
                    <!-- item-->
                    <router-link class="dropdown-item" :to="{ name: 'Profile User' }">
                        <i class="ri-user-line align-middle mr-1"></i> Profile
                    </router-link>
                    <a class="dropdown-item" href="#">
                        <i class="ri-wallet-2-line align-middle me-1"></i>
                        My Wallet
                    </a>
                    <a class="dropdown-item d-block" href="#">
                        <i class="ri-settings-2-line align-middle me-1"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="ri-lock-unlock-line align-middle me-1"></i>
                        Lockscreen
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" @click="logout">
                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                        Logout
                    </a>
                </b-dropdown>
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
