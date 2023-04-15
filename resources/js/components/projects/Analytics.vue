<script>
import { staticProject } from "../../helpers/statisproject";
import {
    projectMethods,
    projectGetters,
    authMethods,
    authGetters
} from "../../store/helpers";
import PageHeader from "../layouts/page-header.vue";
import VueApexCharts from "vue3-apexcharts";
import AnalyticsDep from "./analytics/Depart.vue"
import AnalyticsProject from "./analytics/Project.vue"
export default {
    components: {
        PageHeader,
        apexchart: VueApexCharts,
        AnalyticsDep,
        AnalyticsProject
    },
    data() {
        return {
            slug:this.$route.params.slug,
            title: "",
            items: [],
            results:[],
        };
    },
    computed: {
        ...projectGetters
    },
    methods: {
        ...projectMethods,
        /**
         * 
         * @param {*} data => all task in department
         */
        analyticProject(){
            return staticProject.statisticalProject(this.currentProject.departments)
        },
        // analyticProject : () => staticProject.statisticalProject(this.currentProject.departments),  
    },
    async created() {
        await this.getProject(this.slug);
        this.title = this.currentProject.title;
        this.items = [
            {
                text: "Gosu",
                href: "/",
            },
            {
                text: this.currentProject.title,
                active: true,
            },
        ];
        this.results = this.analyticProject();        
    },
    async mounted() {
    },
};
</script>
<template>
    <div class="container-fluid min-vh-100">
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-xl-4">
                <AnalyticsProject :results="results" :title="currentProject.title"></AnalyticsProject>
            </div>
            <div class="col-xl-8">
                <AnalyticsDep :results="results.results" :id="currentProject.id" :slug="currentProject.slug"></AnalyticsDep>
            </div>
        </div>
    </div>
</template>