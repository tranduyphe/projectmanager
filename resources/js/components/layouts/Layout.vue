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
<style lang="scss">
    // @import "~bootstrap/scss/maps";
    // @import "~bootstrap/scss/utilities";
    // @import '../../../../resources/assets/scss/app.scss';
    // @import '~@/app.scss';    
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        position: relative;
        // padding-right: 12px;
        // padding-left: 12px;
    } 
</style>
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