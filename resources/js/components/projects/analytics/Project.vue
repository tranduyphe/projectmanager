<script>
import { VueEditor } from "vue3-editor";
import {
    authGetters,
    projectMethods
} from "@/js/store/helpers";
import { checkRolesAccess, checkPermissionAccess } from '@/js/middleware/access.js';
import { optionChart } from "@/js/helpers/chart";
import moment from "moment";
import Swal from "sweetalert2";
export default {
    components: {
        VueEditor
    },
    props: {
        results: {
            type: Object,
            default: () => {
                return {}
            },
        },
        title: {
            type: String,
            default: () => {
                return ""
            },
        },
        project: {
            type: Object,
            default: () => {
                return {}
            },
        },
    },
    data() {
        return {
            series: [],
            chartOption: {},
            data: {},
            show:false,
            images: null,
            publicPath : process.env.PUBLIC_URL,
            file:null
        };
    },
    computed: {
        ...authGetters,
    },
    methods: {
        ...projectMethods,
        options:() => optionChart.optionProject(),
        checkRolesAccess:(roles) => checkRolesAccess(roles),
        onChangeImages(e){
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.file = e.target.files[0];
            const reader = new FileReader()
            reader.onload = (event) => {
                this.images = event.target.result
            }
            reader.readAsDataURL(this.file)
        },
        async onUpdateProject(){
            var data = {
                'id':this.project.id,
                'file': this.file,
                'data': {
                    'title':this.project.title,
                    'end_time':moment(this.project.end_time).format('YYYY-MM-DD HH:mm:ss'),
                    'start_time':moment(this.project.start_time).format('YYYY-MM-DD HH:mm:ss'),
                    'description':this.project.description,
                }
            }
            var results = await this.updateProject(data);
            if (results) {
                Swal.fire({
                    position: 'bottom-start',
                    icon: 'success',
                    title: 'Update project successfully',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                // console.log('results', results)
                // this.project = results;
                this.$emit('updateProject', results );
                setTimeout(() => {
                    this.show = false
                }, 2000);
                
            }
        },
        onShowModal(){
            this.show = true
        }
    },
    watch: {
        results: function() {
            this.data = this.$props.results;
            this.chartOption = this.options();
            this.series = [this.results.total];       
            this.chartOption['labels'] = ['Progress'];       
            if (this.data.total == 100) {
                this.chartOption['colors'] = '#7bd405';
                this.chartOption['labels'] = ['Success'];   
            }
        },        
    }, 
    created() {
    },   
};
</script>
<template>
    <b-modal
        v-model="show"
        title="Edit Project"
        size="xl"
        hide-footer
    >
        <form @submit.prevent="onUpdateProject">
            <b-form-group
                label="Title Project"
                label-for="title-input"
            >
                <b-form-input
                    id="title-project"
                    v-model="project.title"
                    required
                >
                </b-form-input>
            </b-form-group>
            <b-form-group
                label="Description"
                label-for="title-input"
            >
                <vue-editor
                    v-model="project.description"
                ></vue-editor>
            </b-form-group>
            <b-form-group
                label="Start Date"
                label-for="datetime-picker"
            >
                <VueDatePicker
                    required
                    v-model="project.start_time"
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
                    v-model="project.end_time"
                    auto-apply
                    :month-change-on-scroll="false"
                />
            </b-form-group>
            <div class="wrap-img">
                <div class="images-projects" v-if="images">
                    <img :src="`${images}`" alt="">
                </div>
                <div class="images-projects" v-else-if="project.url_image">
                    <img :src="`${publicPath+'projects/'+project.url_image}`" alt="">
                </div>
            </div>
            <div class="btn_edit_image">
                <label for="edit_image">Add Image</label>
                <input type="file" id="edit_image" role="button" accept="image/*"  @change="onChangeImages">
            </div>
            <div :class="['modal-footer']">
                <b-button type="submit" variant="primary"
                    >Update</b-button
                >
            </div>
        </form>
    </b-modal>
    <div class="card">
        <div class="card-body">
            <button role="button" class="btn btn-primary" v-if="checkRolesAccess(['administrator', 'manager'])" @click="onShowModal">Edit</button>
            <h4 class="card-title mb-4 text-center">{{ title }}</h4>
            <apexchart                            
                type="radialBar"
                dir="ltr"
                :series="series"
                :options="chartOption"
            ></apexchart>
            <div class="infomation">
                <div class="wrap-img">
                    <div class="images-projects" v-if="project.url_image">
                        <img :src="`${publicPath+'projects/'+project.url_image}`" alt="">
                    </div>
                </div>
                <div
                    v-if="project.description"
                    v-bind:innerHTML="`${
                        project.description
                            ? project.description
                            : ''
                    }`"
                    :class="['content-desc mt-5']"
                ></div>
                <div class="date">
                    <span><strong>Start date</strong>{{ project.start_time }}</span>
                    <span><strong>End date</strong>{{ project.end_time }}</span>
                </div>                
            </div>
        </div>                    
    </div>
</template>
<style lang="scss">
    .btn_edit_image{
             input{
                display: none;
             }
             label{
                padding: 8px;
                background: #dcdee2;
                border-radius: 3px;
             }
        }
    .modal-footer{
        border: 0;
    }
    form {
        .wrap-img {
            .images-projects {
                margin: 0 0 10px;
            }
        }
    }
    .wrap-img {
        .images-projects {
            width: 150px;
            height: 200px;
            position: relative;
            margin: 0 auto;
            img{
                width: 100%;
                height: 100%;
                position: absolute;
                object-fit: cover;
            }
        }
    }
    
</style>