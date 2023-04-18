<script>
import { VueEditor } from "vue3-editor";
import {
    authGetters,
    projectMethods
} from "../../../store/helpers";
import { checkRolesAccess, checkPermissionAccess } from '../../../middleware/access.js';
import { optionChart } from "../../../helpers/chart";
import moment from "moment";
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
            show:false
        };
    },
    computed: {
        ...authGetters,
    },
    methods: {
        ...projectMethods,
        options:() => optionChart.optionProject(),
        checkRolesAccess:(roles) => checkRolesAccess(roles),
        async onUpdateProject(){
            var data = {
                'id':this.project.id,
                'data': {
                    'title':this.project.title,
                    'end_time':moment(this.project.end_time).format('YYYY-MM-DD HH:mm:ss'),
                    'start_time':moment(this.project.start_time).format('YYYY-MM-DD HH:mm:ss'),
                    'description':this.project.description,
                }
            }
            var results = await this.updateProject(data);
            if (results) {
                this.$emit('updateProject', data['data'] );
                this.show = false
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
        }
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
            <div
            v-if="project.description"
            v-bind:innerHTML="`${
                project.description
                    ? project.description
                    : ''
            }`"
            :class="['content-desc']"
        ></div>
        </div>                    
    </div>
</template>