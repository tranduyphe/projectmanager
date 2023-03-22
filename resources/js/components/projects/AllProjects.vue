<script>
import { mapGetters, mapActions, mutations } from 'vuex';
import { VueEditor } from "vue3-editor";
export default {
    components: {
        VueEditor,
    },
    data() {
        return {
            projectData:this.$store.getters.projectData,
            auth: this.$store.getters.authUser,
            loading: false,
            show: false,
        };        
    },
    computed: {
        ...mapGetters([
            'listProjects',
        ])
    },
    methods: {
        ...mapActions(['getProjects', 'createProject']),
        showModal() {
            this.show = true
        },

        addProject() {
            this.createProject(this.projectData);
        },

        resetForm() {
            this.projectData = {};
        },


    },
    created(){  
    },
    mounted() {     
        this.getProjects();
        
    },
};
</script>
<template>    
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">  
                <b-modal v-model="show" title="New Project" @hidden="resetForm" hide-footer>
                    <form @submit.prevent="addProject" >
                        <b-form-group label="Title Project" label-for="title-input">
                            <b-form-input  
                                id="title-project" 
                                v-model="projectData.title"
                                required
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group label="Description" label-for="title-input">
                            <vue-editor v-model="projectData.description"></vue-editor>
                        </b-form-group>
                        <b-form-group label="Start Date" label-for="datetime-picker">
                            <VueDatePicker required v-model="projectData.start_time"/>
                        </b-form-group>
                        <b-form-group label="End Date" label-for="datetime-picker">
                            <VueDatePicker required v-model="projectData.end_time"/>
                        </b-form-group>
                        <b-button type="submit" variant="primary">Submit</b-button>
                    </form>
                </b-modal>      
                <b-button variant="primary" @click="showModal">Add new project</b-button>
                <div class="authentication-page-content p-4 d-flex min-vh-100">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div>
                                    <ol>
                                        <li v-for=" (project, index) in listProjects">                                            
                                            <router-link
                                                :to="{
                                                    name: 'viewproject',
                                                    params: { id: project.id },
                                                }"
                                                class="p-1 mr-1 cursor-pointer"
                                            >
                                            {{ project.title }}
                                            </router-link>
                                        </li>
                                    </ol>
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