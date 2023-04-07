<script>
// import { taskMethods, taskGetters} from "../../store/helpers";
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import moment from "moment";
export default {
    props: {
        works: {
            type: Object,
            default: () => {
                return {}
            },
        },
    },
    data() {
        return {
            showActiveChecklist: {},
            activeEditChecklist: {},
            calculateChecklist:  {},
            nameChecklist: "",
            checked: true,
            isActive:false,
        };
    },
    computed: {
        ...taskGetters
    },
    methods: {
        ...taskMethods,
        // add new  work todo
        async deleteWordToto(id){
            var status = await this.removeWorkTodo(id);
            if (status == 200) {
                if (this.currentTask.works[id]) {
                    delete this.currentTask.works[id]
                    delete this.listTasks[this.currentTask.id].works[id]
                }
            } 
        },

        // add new list check in work todo
        showAddChecklist(id){
            this.showActiveChecklist = {}
            this.showActiveChecklist[id] = !this.showActiveChecklist[id];
        },

        // add new list check in work todo
        showEditChecklist(id){
            this.activeEditChecklist = {}
            this.activeEditChecklist[id] = !this.activeEditChecklist[id];
        },

        // create check list
        async newCheckList(id){
            if (this.nameChecklist) {
                var data = {
                    'id': id,
                    'title': this.nameChecklist
                }
                await taskHelper.addcheckLists(data);
                this.showAddChecklist(id);
                this.nameChecklist = "";
            }    
            this.showActiveChecklist = false;         
        },
        // remove check list
        async deleteCheckList(data){
            await taskHelper.removeCheckListTask(data);
        },

        // update check list
        async updateData(data){
            if (this.works[data['work_id']].check_list[data['id']].title) {
                var dealine = this.works[data['work_id']].check_list[data['id']].dealine 
                dealine = dealine ? moment(dealine).format('YYYY-MM-DD HH:mm:ss') : null;
                var _data = {
                    'title': this.works[data['work_id']].check_list[data['id']].title,
                    'dealine': dealine,
                    'status': !this.works[data['work_id']].check_list[data['id']].status ? 1 : 0,
                }
                data['data'] = _data;
                var result = await taskHelper.updatedDataChecklist(data);
                if (result == 200) {
                    this.activeEditChecklist  = {};
                }
            }
        },
        // calculate number check list
        percent(data){
            return taskHelper.calculateListWorkTodo(data);
        },
        
    },
    created() {
    },
    mounted() {
    },
}
</script>
<template>
    <div class="list_work_todo">
        <div class="work-todo" v-for="(work) in works" >
            <div
                class="work-todo-header d-flex flex-row align-items-center"                                    
            >
                <div :class="['d-flex flex-row align-items-center name']">
                    <i class="ri-checkbox-line"></i>
                    <span>{{ work.title }}</span>
                </div> 
                <b-button variant="light" @click="deleteWordToto(work.id)">Xóa</b-button>       
            </div>
            <div class="d-flex align-items-center">
                <span>{{ percent(works)['percent'][work.id]+'%' }}</span>
                <b-progress :value="percent(works)['percent'][work.id]" :max="100" :variant="`${percent(works)['percent'][work.id] == 100 ? 'success' : ''}`"></b-progress>
            </div>
            <div v-if="work.check_list && work.check_list.length != 0">
                <div :class="['d-flex justify-content-between align-items-center']" 
                    v-for="(checklist, index) in work.check_list"
                    :key="index"
                >
                    <div class='d-flex justify-content-between align-items-center check'>
                        <b-form-checkbox
                            :class="{ shake: percent(works)['percent'][work.id]==100 }"
                            class='d-flex justify-content-between align-items-center'
                            v-model="checklist.status"  
                            @click="updateData({'id': checklist.id, 'work_id':work.id});"                                                                
                        >
                        <!-- @click="updateData({'id': checklist.id, 'work_id':work.id})"  -->
                        </b-form-checkbox>
                        <div class="textarea">
                            <div @click="showEditChecklist(index)">
                                <b-form-textarea
                                    :class="[`${ activeEditChecklist[index] ? 'show-textarea' : ''}`, 'form-control']"
                                    row="3"
                                    v-model="checklist.title"
                                    >
                                </b-form-textarea>
                            </div>
                            <div :class="['d-flex justify-content-between align-items-center']" v-if="activeEditChecklist[index]">
                                <div :class="['d-flex justify-content-between align-items-center']">
                                    <b-button @click="updateData({'id': checklist.id, 'work_id':work.id})" variant="primary">Lưu</b-button>
                                    <b-button @click="activeEditChecklist[index] = !activeEditChecklist[index]" variant="light"><i class="ri-close-fill"></i></b-button>
                                </div>
                                <div :class="['d-flex justify-content-between align-items-center']">
                                    <b-button variant="light">
                                        <VueDatePicker
                                            v-model="checklist.dealine"
                                            auto-apply
                                            @closed="updateData({'id': checklist.id, 'work_id':work.id})"
                                            :month-change-on-scroll="false"
                                        >
                                        <template #trigger><i class="ri-time-line"></i></template>
                                        </VueDatePicker> 
                                    </b-button>
                                    <b-button variant="light" @click="deleteCheckList({'id': checklist.id, 'work_id':work.id})"><i class="ri-delete-bin-7-line"></i></b-button>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!activeEditChecklist[index]" :class="['d-flex justify-content-between align-items-center']">
                        <b-button variant="light">
                            <VueDatePicker
                                v-model="checklist.dealine"
                                auto-apply
                                @closed="updateData({'id': checklist.id, 'work_id':work.id})"
                                :month-change-on-scroll="false"
                            >
                            <template #trigger><i class="ri-time-line"></i></template>
                            </VueDatePicker>
                        </b-button>  
                        <b-button variant="light" @click="deleteCheckList({'id': checklist.id, 'work_id':work.id})"><i class="ri-delete-bin-7-line"></i></b-button>  
                    </div>
                </div>
            </div>
            <div :class="['mt-3 ms-3 ps-1']" v-if="showActiveChecklist[work.id]">
                <div>
                    <b-form-textarea
                        v-model="nameChecklist"
                        placeholder="Enter something..."
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </div>
                <div :class="['mt-2']">
                    <b-button @click="newCheckList(work.id);" variant="primary">Thêm</b-button>
                    <b-button @click="showActiveChecklist[work.id] = !showActiveChecklist[work.id]" variant="light">Hủy</b-button>
                </div>
            </div>
            <b-button class="btn_add mb-3" v-if="!showActiveChecklist[work.id]" variant="light" @click="showAddChecklist(work.id)">Thêm một mục</b-button>
        </div>
    </div>
</template>
