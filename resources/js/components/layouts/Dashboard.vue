<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import SideBar from "./SiderBar.vue";
import AllProject from "../projects/AllProjects.vue";
export default {
    components: {
        Header,
        Footer,
        SideBar,
        AllProject
    },
    data() {
        return {
            task: {},
            loading: false,
        };
    },
    methods: {     
        createNewTask() {
            this.loading = true;
            axios
                .post('/api/tasks/create', this.task)
                .then(response => {
                    //console.log(response);
                    this.product = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    // created: () => {
    //     document.body.removeAttribute("data-layout", "horizontal");
    //     document.body.removeAttribute("data-topbar", "dark");
    //     document.body.setAttribute("data-sidebar", "dark");
    // },
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
        }
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
                    <AllProject />
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->
            <Footer />
        </div>
        <!-- END layout-wrapper -->
    </div>
</template>
