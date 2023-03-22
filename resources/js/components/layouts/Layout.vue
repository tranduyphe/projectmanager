<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import SideBar from "./SiderBar.vue";
export default {
    components:{
        Header,
        Footer,
        SideBar,
    },
    mounted() {
        document.body.classList.remove("auth-body-bg");
        if (this.loader === true) {
        document.getElementById("preloader").style.display = "block";
        document.getElementById("status").style.display = "block";

        setTimeout(function () {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        }, 2500);
        } else {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        };
    },
};
</script>
<template>
    <div>
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
                    <!--  -->
                    <h1>lên layout html ở page này nhé</h1>
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->
            <Footer />
        </div>
        <!-- END layout-wrapper -->
    </div>
</template>