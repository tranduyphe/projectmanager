<script>
import { VueDraggableNext } from "vue-draggable-next";
import PageHeader from "../layouts/page-header.vue";
import moment from "moment";
import { taskHelper } from "../../helpers/helptask";
import { taskMethods, authMethods, labelMethods, taskGetters, labelGetters, authGetters } from "../../store/helpers";
import MoveCard from "./project/MoveCard.vue";
import CheckList from "./project/checklists.vue";
import TaskDeadline from "./project/taskdeadline.vue";
import FilesTask from "./project/FilesTask.vue";
import FileUploads from "./project/UploadFiles.vue";
import UserTask from "./project/Users.vue";
import Labels from "./project/Labels.vue";
import Works from "./project/Words.vue";
import DateTasks from "./project/DateTask.vue";
import Description from "./project/Description.vue";
export default {   
    page: {
        title: "Gosu Board",
        meta: [{ name: "description" }],
    },
    components: {
        draggable: VueDraggableNext,
        PageHeader,
        CheckList,
        TaskDeadline,
        MoveCard,
        FilesTask,
        FileUploads, 
        UserTask,
        Labels,
        Works,
        DateTasks,
        Description
    },
    data() {
        return {
            buttonAdd: {},
            newTasks: {},
            allPopUp: {},
            showModal: false,
            showActive: false,
            showModalFilter2: false,
            project_id: parseInt(this.$route.params.id),
            placeholder: "Nhập tiêu đề cho thẻ này...",
            taskUpdate: {},
            title: "Gosu Board",
            items: [
                {
                    text: "Gosu",
                    href: "/",
                },
                {
                    text: "Gosu Board",
                    active: true,
                },
            ],
            dataUpdated: {},
        };
    },
    computed: {
        ...taskGetters,
        ...labelGetters,
        ...authGetters
    },
    methods: {
        ...taskMethods,
        ...authMethods,
        ...labelMethods,
        handlerClick($id) {
            for (const key in this.listCard) {
                const cardProject = this.listCard[key];
                this.buttonAdd[cardProject.id] = false;
            }
            this.buttonAdd[$id] = true;
        },

        async createTask($id) {
            this.newTasks["card_id"] = $id;
            this.newTasks["project_id"] = this.project_id;
            if (this.newTasks && this.newTasks["title_" + $id]) {
                var newTask = await this.createNewTask(this.newTasks);
                if (typeof newTask != "undefined") {
                    this.listTaskDraggable[newTask.card_id].push(newTask.id);
                    this.listTasks[newTask.id] = newTask;
                }
                this.newTasks = {};
            }
        },

        changeTask(event, cardId) {
            if (typeof event.added != "undefined") {
                this.taskUpdate["task_id"] = event.added.element;
                this.taskUpdate["info_task"] = {
                    card_id: cardId,
                };
                this.updateTask(this.taskUpdate);
            }
        },

        showTask(data) {
            this.getCurrentTask(data);
            this.showModal = true;
        },

        /**
         *
         * @param {*} value returm date
         */
        dateTime(value) {
            return moment(value).format("ll");
        },

        // check hiden modal
        onHideModal(evt) {
            if (evt.trigger === "backdrop") {
                // if (this.showEditor == true) {
                //     evt.preventDefault();
                //     this.showEditor = false;
                //     this.showModalMember = false;
                // } else {
                //     this.showModal = false;
                // }
            }
        },
        //updated data task
        async updateDataCurrentTask( obj ) {
            await taskHelper.updateDataTask( obj )
        },
        // calculate number check list
        calulateCheckList(data){
            return taskHelper.calculateListWorkTodo(data);
        },
        async onPaste (pasteEvent, callback) {            
            if (!this.allPopUp['editor']) {
                if(pasteEvent.clipboardData == false){
                    if(typeof(callback) == "function"){
                        callback(undefined);
                    }
                };
                var url = pasteEvent.clipboardData.getData('text');
                if (taskHelper.validateUrl(url)) {
                    var dataUrl = taskHelper.validateUrl(url)
                    var data = {
                        'url': url,
                        'name': dataUrl[4],
                        'task_id': this.currentTask.id
                    }
                    var results = await this.uploadFile(data);
                    if (results) {
                        this.listTasks[this.currentTask.id]['list_files'] = results.list_files;
                        this.currentTask['list_files'] = results.list_files
                    }
                }else{
                    var items = pasteEvent.clipboardData.items;
                    if(items == undefined){
                        if(typeof(callback) == "function"){
                            callback(undefined);
                        }
                    };
                    for (var i = 0; i < items.length; i++) {
                        if (items[i].type.indexOf("image") == -1) continue;
                        var blob = items[i].getAsFile();
                        const fileUpload = new Blob([blob], blob);
                        const formData = new FormData();
                        formData.append('file', fileUpload, blob.name);
                        formData.append('task_id', this.currentTask.id);                        
                    }
                    if (typeof formData != 'undefined') {
                        var results = await this.uploadFile(formData);
                        if (results) {
                            this.listTasks[this.currentTask.id] = results;
                            this.currentTask['list_files'] = results.list_files
                        }
                    }
                    
                }
            }            
        },

        // hidden modal 
        hideModalPopup(data){
            this.allPopUp[data] = false;
        },
        // hidden modal 
        showModalPopup(data){
            this.allPopUp[data] = true;
        },

        // calculate files cards
        fileTasks(data){
            return taskHelper.countFileTasks(data);
        }
    },
    async created() {
        await this.auth();
        await this.getListCards();
        await this.getLabels();        
        await this.getListTasks(this.$route.params.id);
    },

    async mounted() {        
        document.body.classList.remove("auth-body-bg");
        document.body.classList.add("page-task"); 
    },
};
</script>
<template>
    <!-- <pre>{{ JSON.stringify(listItemLabels, undefined, 4) }}</pre> @paste="onPaste"-->
    <b-modal
        v-model="showModal"
        @hide="onHideModal"
        size="lg"
        hide-footer
        hide-header        
    >
        <div :class="['container-fluid']">
            <div :class="['row']">
                <div
                    :class="[
                        'col-12 d-flex flex-row align-items-center justify-content-between',
                    ]"
                >
                    <div class="name_card">
                        <p class="d-flex flex-row fs-3">
                            <i class="ri-archive-fill"></i>
                            <span>{{ currentTask.title }}</span>
                        </p>
                        <span>Trong danh sách <a href="">Task</a></span>
                    </div>
                    <div :class="['btn_close']" @click="showModal = !showModal">
                        <i class="ri-close-line"></i>
                    </div>
                </div>
                <div :class="['col-9']">
                    <div :class="['content-main-info']">
                        <div class="member" v-if="currentTask.members">
                            <p>Thành viên</p>
                            <div :class="['d-flex align-items-center']" >
                            <div class="list_user">
                                <div
                                    class="user"
                                    v-for="(
                                        userTask, index
                                    ) in currentTask.members"
                                    :key="index"
                                >
                                    <img
                                        src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                        :title="userTask.name"
                                    />
                                </div>
                            </div>
                            <div class="btn_add_user d-flex align-items-center justify-content-center ms-2">
                                <i class="ri-add-line"></i>
                            </div>
                          </div>
                            
                        </div>
                        <div class="label" v-if="currentTask.task_labels">
                            <p>Nhãn</p>
                            <div class="list_label">
                                <div class="name_label" :style="{ background: label.color}"
                                v-for="(
                                    label, index
                                ) in currentTask.task_labels"
                                :key="index"
                                >
                                    <div class="label_active"></div>
                                </div> 
                                <div class="btn_add_label" @click="showModalFilter2 =true">
                                   
                                   <div class="item">
                                       <i class="ri-add-line"></i>
                                   </div>
                               <div class="modalFilter modalFilter2" v-if="showModalFilter2">
                                   <div
                                       :class="[
                                           'modalFilter-header d-flex flex-row align-items-center justify-content-between',
                                       ]"
                                   >
                                       <span>Nhãn</span>
                                       <a
                                           @click.stop="
                                               showModalFilter2 =
                                                   !showModalFilter2
                                           "
                                           ><i class="ri-close-line"></i
                                       ></a>
                                   </div>
                                   <div class="filter_of_table" v-for="(label,index) in listItemLabels" :key="index">
                                       <div
                                           class="list_color d-flex flex-row align-items-center"
                                           
                                           @click="updateDataCurrentTask(
                                               {
                                                   'action' : currentTask.task_labels ? !currentTask.task_labels[label.id] ? 'active' : 'deactive' : 'active',
                                                   'id' : label.id,
                                                   'data': label,
                                                   'key' : 'task_labels',
                                                   'field': 'labels',
                                               }
                                           )"
                                       >
                                           <i :class="`${ currentTask.task_labels ? !currentTask.task_labels[label.id] ? 'ri-checkbox-blank-line' : 'ri-checkbox-line' : 'ri-checkbox-blank-line' }`"></i>
                                           <div class="color color1"  :style="{ background: label.color}">
                                               <div class="color_child"></div>
                                               <p class="ms-2">{{ label.name }}</p>
                                           </div>
                                       </div>                                       
                                   </div>
                               </div>
                               </div>                                
                            </div>
                        </div>
                        <TaskDeadline :deadline="currentTask.deadline"></TaskDeadline>
                    </div>
                    <div :class="['content-main-detail']">
                        <Description @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['editor']"></Description>                                               
                        <CheckList :works="currentTask.works"></CheckList>   
                        <FilesTask @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['files1']"></FilesTask>   
                                             
                    </div>
                    <div :class="['content-main-detail']">
                        <h6 d-flex flex-row align-items-center>
                            <i class="ri-list-check"></i><span>Hoạt động</span>
                        </h6>
                        <div class="textarea">
                            <textarea
                            class="textarea_active"
                            placeholder="Viết bình luận..."
                            v-if="!showActive"
                            @click-outside="showActive = !showActive"
                        ></textarea>
                        </div>
                        
                        <div :class="['description']" v-if="showActive">
                            <div :class="['content-desc']"></div>
                            <div :class="['content-editor']">
                                <vue-editor
                                    id="edit-current-task"
                                    v-model="currentTask.description"
                                ></vue-editor>
                            </div>
                            <div class="list_button">
                                <div class="btn_save bg-primary">Lưu</div>
                                <div
                                    class="btn_cancel bg-danger"
                                    @click="showActive = !showActive"
                                >
                                    Hủy
                                </div>
                            </div>
                        </div>
                        <div :class="['list-work']">
                            <div class="history_active">
                                <div class="avatar">
                                    <div class="image">
                                        <img
                                            src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                            alt=""
                                        />
                                    </div>
                                </div>
                                <div class="history_active-content">
                                    <p>
                                        <b class="name">Nguyễn Khánh Lợi</b> đã
                                        tham gia thẻ này
                                    </p>
                                    <p class="time">2 Th12 2022 lúc 09:11</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="['col-3']">
                    <div :class="['list-item']">
                        <h6>Thêm vào thẻ</h6>
                        <b-list-group>
                            <UserTask @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['user']"></UserTask>
                            <Labels :labels = "listItemLabels" @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['label']"></Labels>                            
                            <Works @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['works']"></Works>                            
                            <DateTasks></DateTasks>                            
                            <FileUploads @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['files']"></FileUploads> 
                        </b-list-group>
                    </div>
                    <div :class="['list-item']">
                        <MoveCard :cards="listCard"  @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="allPopUp['move']"></MoveCard> 
                    </div>
                </div>
            </div>
        </div>
    </b-modal>

    <div class="container-fluid min-vh-100">
        <PageHeader :title="title" :items="items" />
        <!-- nav -->
        <div class="layoutview-header">
            <div class="layoutview-header-left">
                <h4 class="name_project">PROJECT</h4>
                <div
                    class="icon_star"
                    title="Đánh hoặc bỏ đánh dấu sao bảng này. Bảng được đánh dấu sao sẽ hiện ở đầu danh sách Bảng."
                >
                    <i class="ri-star-line"></i>
                </div>
                <a class="btn_display_working_space">
                    <div class="icon">
                        <i class="ri-group-line"></i>
                    </div>
                    <p>Hiển thị không gian làm việc</p>
                </a>
                <a class="btn_table">
                    <div class="icon">
                        <i class="ri-table-alt-line"></i>
                    </div>
                    <p>Bảng</p>
                </a>
                <div class="btn_dropdown">
                    <i class="ri-arrow-drop-down-line"></i>
                </div>
            </div>
            <div class="layoutview-header-right">
                <a class="btn_add-ons">
                    <div class="icon">
                        <i class="ri-rocket-2-line"></i>
                    </div>
                    <p>Tiện ích bổ sung</p>
                </a>
                <a class="btn_automation">
                    <i class="ri-flashlight-line"></i>
                    <p>Tự động hóa</p>
                </a>
                <a class="btn_filter">
                    <div class="icon"><i class="ri-filter-3-line"></i></div>
                    <p>Lọc</p>
                </a>
                <div class="list_user">
                    <div class="avatar">
                        <img
                            src="/images/avatar-1.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                            alt=""
                        />
                    </div>
                    <div class="avatar">
                        <img
                            src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                            alt=""
                        />
                    </div>
                    <div class="avatar">
                        <img
                            src="/images/avatar-3.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                            alt=""
                        />
                    </div>
                    <div class="avatar">
                        <img
                            src="/images/avatar-4.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                            alt=""
                        />
                    </div>
                </div>
                <a class="btn_share">
                    <div class="icon"><i class="ri-user-add-line"></i></div>
                    <p>Chia sẻ</p>
                </a>
                <a class="btn_menu">
                    <i class="ri-more-line"></i>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-6">
                <div class="media">
                    <div class="me-3">
                        <img
                            src="@/assets/images/logo-sm-light.png"
                            alt
                            class="avatar-xs"
                        />
                    </div>
                    <div class="media-body">
                        <h5>Gosu Dashboard</h5>
                        <span class="badge badge-soft-success">Open</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a
                                href="javascript: void(0);"
                                class="d-inline-block"
                                v-b-tooltip.hover
                                title="Aaron Williams"
                            >
                                <img
                                    src="@/assets/images/users/avatar-2.jpg"
                                    class="rounded-circle avatar-xs"
                                    alt
                                />
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a
                                href="javascript: void(0);"
                                class="d-inline-block"
                                v-b-tooltip.hover
                                title="Jonathan McKinney"
                            >
                                <div class="avatar-xs">
                                    <span
                                        class="avatar-title rounded-circle bg-soft-primary text-primary"
                                        >J</span
                                    >
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a
                                href="javascript: void(0);"
                                class="d-inline-block"
                                v-b-tooltip.hover
                                title="Carole Connolly"
                            >
                                <img
                                    src="@/assets/images/users/avatar-4.jpg"
                                    class="rounded-circle avatar-xs"
                                    alt
                                />
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="py-1">
                                <i class="mdi mdi-plus me-1"></i> New member
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div
                v-for="(card, index) in listCard"
                :key="index++"
                :class="['col-3']"
            >
                <div class="card-body">
                    <b-dropdown right class="float-end" variant="white">
                        <template v-slot:button-content>
                            <i
                                class="mdi mdi-dots-vertical m-0 text-muted font-size-20"
                            ></i>
                        </template>
                        <b-dropdown-item>Edit</b-dropdown-item>
                        <b-dropdown-item>Delete</b-dropdown-item>
                    </b-dropdown>

                    <!-- end dropdown -->
                    <h4 class="card-title">{{ card.title }}</h4>
                </div>
                <div class="card">
                    <div class="card-body border-bottom">
                        <div :id="`${'wrap_card_'+card.id}`" class="task-list">
                            <draggable
                                class="list-group"
                                group="tasks"
                                :list="listTaskDraggable[card.id]"
                                @change="changeTask($event, card.id)"
                            >
                                <div
                                    class="card task-box cursor-pointer"
                                    v-for="(task, index) in listTaskDraggable[
                                        card.id
                                    ]"
                                    :key="index"
                                    :id="`${'task_'+task}`"
                                    @click="showTask(listTasks[task])"
                                >
                                    <!-- <pre>{{ JSON.stringify(task, undefined, 4) }}</pre> -->
                                    <b-progress :value="calulateCheckList(listTasks[task].works).percentTask" :max="100" :variant="`${calulateCheckList(listTasks[task].works).percentTask == 100 ? 'success' : ''}`"></b-progress>
                                    <div class="card-body">
                                        <div class="list_filter" v-if="listTasks[
                                                        task
                                                    ].task_labels">
                                            <div class="filter" 
                                                v-for="member in listTasks[
                                                    task
                                                ].task_labels"                                               
                                            >
                                            </div>
                                        </div>
                                        <div class="float-end ml-2">
                                            <div>
                                                {{
                                                    dateTime(
                                                        listTasks[task]
                                                            .created_at
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <a href="#" class
                                                >#{{ listTasks[task].id }}</a
                                            >
                                        </div>
                                        <div>
                                            <h5 class="font-size-16">
                                                <a
                                                    href="javascript: void(0);"
                                                    class="text-dark"
                                                    >{{
                                                        listTasks[task].title
                                                    }}</a
                                                >
                                            </h5>
                                        </div>
                                        <div class="d-flex team mb-0">
                                            <div :class="['d-flex align-items-center']" v-if="listTasks[task].list_files">
                                                <i class="ri-attachment-2"></i>
                                                {{ fileTasks(listTasks[task].list_files) }}
                                            </div>
                                            <div 
                                                :class="['d-flex align-items-center']"
                                                v-if = "calulateCheckList(listTasks[task].works).total != 0"
                                            >   
                                                <i class="ri-checkbox-line"></i>
                                                {{ 
                                                   calulateCheckList(listTasks[task].works).done+'/'+calulateCheckList(listTasks[task].works).total
                                                }}
                                            </div>
                                            <div
                                                class="align-self-center d-flex"
                                                v-if="listTasks[task].members"
                                            >
                                                <div
                                                    class="list-member"
                                                    v-for="member in listTasks[
                                                        task
                                                    ].members"
                                                >
                                                    <div class="team-member">
                                                        <a
                                                            href="javascript: void(0);"
                                                            class="team-member d-inline-block"
                                                            v-b-tooltip.hover
                                                            data-placement="top"
                                                            :title="member.name"
                                                        >
                                                            <img
                                                                src="@/assets/images/users/avatar-2.jpg"
                                                                class="rounded-circle avatar-xs"
                                                                alt
                                                            />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </draggable>
                            <!-- end task card -->
                            <div
                                :class="['open-card']"
                                v-if="buttonAdd[card.id]"
                            >
                                <b-form-textarea
                                    :name="'card_id_' + card.id"
                                    v-model="newTasks['title_' + card.id]"
                                    :placeholder="placeholder"
                                    :id="card.id"
                                    rows="3"
                                    max-rows="6"
                                    :class="['mb-3']"
                                ></b-form-textarea>
                            </div>
                            <button
                                class="btn"
                                v-if="!buttonAdd[card.id]"
                                @click="handlerClick(card.id)"
                            >
                                <i class="ri-add-line"></i>
                                <span> Thêm thẻ</span>
                            </button>
                            <button
                                class="btn btn-primary mt-1 waves-effect waves-light"
                                v-else
                                @click="createTask(card.id)"
                            >
                                <i class="ri-add-line"></i>
                                <span> Thêm thẻ</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
