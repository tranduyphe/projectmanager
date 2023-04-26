<script>
import { VueEditor } from "vue3-editor";
import Swal from "sweetalert2";
import {
    projectMethods,
    projectGetters,
    authMethods,
    authGetters
} from "@/js/store/helpers";
import PageHeader from "@/js/components/layouts/page-header.vue";
export default {
    components: {
        VueEditor,
        PageHeader
    },
    data() {
        return {
            title: "",
            items: [],
            projectData: {},
            images: null,
            textForm: {
                'create_title': "Tạo dự án mới",
                'title': "Tên dự án",
                'place_title': "Nhập tên dự án",
                'desc': "Mô tả dự án",
                'start': "Thời gian bắt đầu",
                'place_start': "Chọn thời gian bắt đầu",
                'end': "Thời gian kết thúc",
                'place_end': "Chọn thời gian kết thúc",
                'add_image': "Thêm hình ảnh",
                'name_button_create': "Tạo mới",
            },
            load: true
        };
    },
    computed: {
        ...projectGetters,
        ...authGetters,
    },
    methods: {
        ...projectMethods,
        ...authMethods,
        onChangeImages(e){
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.projectData['file'] = e.target.files[0];

            const reader = new FileReader()
            reader.onload = (event) => {
                this.images = event.target.result
            }
            reader.readAsDataURL(this.projectData['file'])
        },
        async addProject() {
            if (this.load) {
                this.load= false;
                var data = await this.createProject(this.projectData);
                if (data) {
                    Swal.fire({
                        position: 'bottom-start',
                        icon: 'success',
                        title: 'Created project successfully',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                    // console.log('results', results)
                    // this.project = results;
                    setTimeout(() => {
                        this.show = false
                    }, 2000);
                }
                this.projectData = {};
                this.images = null;
                this.load = true
            }
            
        }, 
    },
    async created() {       
        this.auth();
        this.title = 'Project';
        this.items = [
            {
                text: "Gosu",
                href: "/",
            },
            {
                text: this.textForm.create_title,
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
                <h2 class="text-center">{{ textForm.create_title }}</h2>
                <div class="form-create-project">
                    <form @submit.prevent="addProject">
                        <b-form-group
                            :label="textForm.title"
                            label-for="title-input"
                        >
                            <b-form-input
                                class="form-control"
                                :placeholder="textForm.place_title"
                                id="title-project"
                                v-model="projectData.title"
                                required
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                            :label="textForm.desc"
                            label-for="title-input"
                        >
                            <vue-editor
                                v-model="projectData.description"
                            ></vue-editor>
                        </b-form-group>
                        <b-form-group
                            :label="textForm.start"
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
                            :label="textForm.end"
                            label-for="datetime-picker"
                        >
                            <VueDatePicker
                                required
                                v-model="projectData.end_time"
                                auto-apply
                                :month-change-on-scroll="false"
                            />
                        </b-form-group>
                        <div class="mb-3 images_projects" v-if="images">
                            <img :src="images" alt="">
                        </div>
                        <div class="btn_add_image mb-3">
                            <label for="add_image">{{ textForm.add_image }}</label>
                            <input type="file" id="add_image" accept="image/*" @change="onChangeImages" role="button">
                        </div>
                        <div>
                            <b-button type="submit" variant="primary"
                                >{{ textForm.name_button_create }}</b-button
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
    // .form-create-project {
    //     max-width: 800px;
    //     margin: 0 auto;
    // }
</style>