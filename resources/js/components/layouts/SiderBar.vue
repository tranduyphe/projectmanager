<script>
import simplebar from "simplebar-vue";
export default {
    components: {
        simplebar,
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
                        <a href="/" class="side-nav-link-ref router-link-active">
                            <i class="bx ri-dashboard-line"></i><span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </simplebar>
    </div>
    <!-- Left Sidebar End -->
</template>