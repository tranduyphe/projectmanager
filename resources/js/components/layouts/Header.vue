<script>
import { mapActions } from "vuex";
import { userHelper } from '../../helpers/users'
export default {
    props: {
        infoAuth: {
            type: Object,
            default: () => {
                return false
            },
        },
    },
    data() {
        return {
            languages: [
                {
                    flag: 'images/us.jpg',
                    language: "en",
                    title: "English",
                },
                {
                    flag: 'images/french.jpg',
                    language: "fr",
                    title: "French",
                },
                {
                    flag: 'images/spain.jpg',
                    language: "es",
                    title: "spanish",
                },
            ],
            current_language: "en",
            avatar: 'images/avatar.png',
            publicPath: process.env.PUBLIC_URL
        };
    },
    computed: {
        fullName() {
            return userHelper.fullName(this.infoAuth)
        }
    },
    methods: {
        ...mapActions(["logout", "auth"]),
        
        toggleMenu() {
            // this.$parent.toggleMenu();
        },
    },
    created() {},
    async mounted() {
        await this.auth();
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img :src="`${publicPath+'images/logo.png'}`" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="`${publicPath+'images/logo.png'}`" alt height="20" />
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
                        <img class :src="`${publicPath+'images/us.jpg'}`" alt="Header Language" height="16" />
                    </template>
                    <b-dropdown-item class="notify-item" v-for="(entry, i) in languages" :key="`Lang${i}`" :value="entry"
                        :link-class="{
                            active: entry.language === current_language,
                        }">
                        <img :src="`${publicPath+entry.flag}`" alt="user-image" class="me-1" height="12" />
                        <span class="align-middle">{{ entry.title }}</span>
                    </b-dropdown-item>
                </b-dropdown>
                <b-dropdown right variant="black" toggle-class="header-item" class="d-inline-block user-dropdown">
                    <template v-slot:button-content>
                        <img class="rounded-circle header-profile-user"
                            alt="Header Avatar" 
                            :src="`${ infoAuth.avatar ? publicPath+'users/'+infoAuth.avatar : publicPath+avatar}`"
                        />
                        <span class="d-none d-xl-inline-block ms-1">
                            {{ fullName }}
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
