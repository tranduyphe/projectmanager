<script>
// import { mapGetters, mapActions, mutations } from "vuex";
import { VueEditor } from "vue3-editor";
import { staticProject } from "../../helpers/statisproject";
import PageHeader from "../layouts/page-header.vue";
import moment from "moment";
import {
    projectMethods,
    projectGetters,
    authMethods,
    authGetters
} from "../../store/helpers";
export default {
    components: {
        VueEditor,
        PageHeader
    },
    data() {
        return {
            title: "",
            items: [],
            projectData: this.$store.getters.projectData,
            authData: this.$store.getters.getAuthUserData,
            show: false,
        };
    },
    computed: {
        ...projectGetters,
        ...authGetters,
    },
    methods: {
        ...projectMethods,
        ...authMethods,
        showModalCreateProject() {
            this.show = true;
        },

        async addProject() {
            var data = await this.createProject(this.projectData);
            this.listProjects.push(data);
            this.show = false;
        },

        resetForm() {
            this.projectData = {};
        },

        statisticalProject(data){
            return staticProject.statisticalTasks(data);
        },

        formatDate(date){
            return moment(date).format('DD-MM-YYYY');
        }
    },
    async created() {       
        this.auth();
        await this.getProjects();
        this.title = 'Projects';
        this.items = [
            {
                text: "Gosu",
                href: "/",
            },
            {
                text: 'Projects',
                active: true,
            },
        ];
    },
};
</script>

<template>
    <div class="container-fluid">        
        <div class="row no-gutters">
            <div class="col-lg-12">
                <PageHeader :title="title" :items="items" />
                <div
                    v-if="
                        authUserData.roles[0].name === 'manager' ||
                        authUserData.roles[0].name === 'administrator'
                    "
                >
                    <b-modal
                        v-model="show"
                        title="New Project"
                        size="xl"
                        @hidden="resetForm"
                        hide-footer
                    >
                        <form @submit.prevent="addProject">
                            <b-form-group
                                label="Title Project"
                                label-for="title-input"
                            >
                                <b-form-input
                                    id="title-project"
                                    v-model="projectData.title"
                                    required
                                >
                                </b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Description"
                                label-for="title-input"
                            >
                                <vue-editor
                                    v-model="projectData.description"
                                ></vue-editor>
                            </b-form-group>
                            <b-form-group
                                label="Start Date"
                                label-for="datetime-picker"
                            >
                                <VueDatePicker
                                    required
                                    v-model="projectData.start_time"
                                    auto-apply
                                    :month-change-on-scroll="false"
                                />
                            </b-form-group>
                            <b-form-group
                                label="End Date"
                                label-for="datetime-picker"
                            >
                                <VueDatePicker
                                    required
                                    v-model="projectData.end_time"
                                    auto-apply
                                    :month-change-on-scroll="false"
                                />
                            </b-form-group>
                            <div :class="['modal-footer']">
                                <b-button type="submit" variant="primary"
                                    >Create</b-button
                                >
                            </div>
                        </form>
                    </b-modal>
                    <b-button variant="primary" @click="showModalCreateProject"
                        >Add new project</b-button
                    >
                </div>
                <div class="row">
                    <div
                        v-for="(project, index) in listProjects"
                        :class="['mb-4 col-lg-3']"
                    >
                        <div class="wrap-item">
                            <div class="item-project" v-if="authUserData.roles[0].name === 'manager' || authUserData.roles[0].name === 'administrator'">
                                <router-link                                                
                                    :to="{
                                        name: 'analytics',
                                        params: { slug: project.slug, id: project.id },
                                    }"                                                                                      
                                >
                                    <p>{{ project.title }}</p>  
                                                                   
                                </router-link>
                            </div>
                            <div class="item-project" v-else>
                                <router-link
                                    :to="{
                                        name: 'project',
                                        params: { slug: project.slug, id: project.id },
                                    }"                                     
                                >
                                    <p>{{ project.title }}</p>
                                    <span class="badge badge-primary">{{ statisticalProject(project.data_task)+'%' }}</span>
                                    <span class="date">
                                        Start: {{ formatDate(project.start_time) }}
                                    </span>
                                    <span class="date">
                                        End: {{ formatDate(project.end_time) }}
                                    </span>
                                </router-link>
                            </div>
                            <div class="item-icon">
                                <div
                                    class="icon-active"
                                    title="Có hoạt động mới trong bảng này."
                                ></div>
                                <div
                                    class="icon-star"
                                    title="Bấm để gắn dấu sao bảng này. Bảng này sẽ được thêm vào danh sách được đánh dấu sao của bạn."
                                >
                                    <i class="ri-star-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</template>
<style lang="scss">
    .wrap-item {
        border-radius: 5px;
        background-color: rgb(0, 121, 191);
        transition: all .3s ease-in-out;
        position: relative;
        top:0;
        overflow: hidden;
        &:hover {
            transition: all .3s ease-in-out;
            top: -5px
        }
        .item-icon {
            display: none;
        }
        .item-project {            
            min-height: 130px;
            position: relative;
            a { 
                color: #fff;
                position: absolute;
                width: 100%;
                height: 100%;
                padding:20px;
                display: flex;
                flex-direction: column;
                &:hover {
                    background-color: rgba($color: #000000, $alpha: .2);
                }
                p {
                    text-transform: uppercase;
                    font-size: 16px;
                    font-weight: bold;
                    padding-right: 50px;
                }
                .badge {
                    position: absolute;
                    top: 20px;
                    right: 0;
                    padding: 6px 8px;
                    border-radius: 30px 0px 0px 30px;
                    background: RED;
                }
                .date {
                    font-size: 14px;
                    text-transform: capitalize;
                    font-style: italic;
                }
            }
        }
    }
</style>