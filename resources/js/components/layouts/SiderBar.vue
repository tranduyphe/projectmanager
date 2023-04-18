<script>
import simplebar from "simplebar-vue";
import { checkRolesAccess, checkPermissionAccess } from '../../middleware/access.js';
export default {
    components: {
        simplebar,
    },
    methods: {
        checkRolesAccess(roles) {
            return checkRolesAccess(roles);
        }
    },
};
</script>
<template>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
        <simplebar class="h-100" ref="currentMenu" id="my-element">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li>
                        <router-link :to="{
                            name: 'dashboard',
                        }" class="side-nav-link-ref">
                            <i class="bx ri-dashboard-line"></i><span>Dashboard</span>
                        </router-link>
                    </li>
                    <li v-if="checkRolesAccess(['administrator', 'leader'])">
                        <router-link :to="{
                            name: 'alluser',
                        }" class="side-nav-link-ref">
                                <i class="ri-user-fill"></i><span>User Manager</span>
                            </router-link>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </simplebar>
    </div>
    <!-- Left Sidebar End -->
</template>