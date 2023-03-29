<script>
import { VueDraggableNext } from "vue-draggable-next";
import { mapGetters, mapActions, mutations } from "vuex";
import PageHeader from "../layouts/page-header.vue";
import moment from "moment";
import { VueEditor } from "vue3-editor";
export default {
    page: {
        title: "Gosu Board",
        meta: [{ name: "description" }],
    },
    components: {
        draggable: VueDraggableNext,
        PageHeader,
        VueEditor,
    },
    data() {
        return {
            buttonAdd: {},
            newTasks: {},
            showModal: false,
            showActive:false,
            showModalMember:false,
            showModalFilter:false,
            showModalWorkToDo:false,
            showModalFile:false,
            showEditor:false,
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
        };
    },
    computed: {
        ...mapGetters(["listCard", "listTasks", "currentTask", "listUsers"]),
    },
    methods: {
        ...mapActions([
            "createNewTask",
            "getListCards",
            "getListTasks",
            "updateTask",
            "getCurrentTask",
        ]),

        handlerClick($id) {
            for (const key in this.listCard) {
                const cardProject = this.listCard[key];
                this.buttonAdd[cardProject.id] = false;
            }
            this.buttonAdd[$id] = true;
        },

        createTask($id) {
            this.newTasks["card_id"] = $id;
            this.newTasks["project_id"] = this.project_id;
            if (this.newTasks && this.newTasks["title_" + $id]) {
                this.createNewTask(this.newTasks);
                this.getListTasks(this.$route.params.id);
                this.newTasks = {};
            }
        },

        changeTask(event, cardId) {
            if (typeof event.added != "undefined") {
                this.taskUpdate["task_id"] = event.added.element.id;
                this.taskUpdate["info_task"] = {
                    card_id: cardId,
                };
                this.updateTask(this.taskUpdate);
            }
        },

        showTask(task_id) {
            this.getCurrentTask(task_id);
            this.showModal = true;
        },


        show_ModalMember() {
            this.showModalMember = !this.showModalMember;
            console.log(this.showModalMember)
        },

        show_Filter() {
            this.showModalFilter = !this.showModalFilter;
        },
        show_File() {
            this.showModalFile = !this.showModalFile;
        },
        show_ModalWorkToDo() {
            this.showModalWorkToDo = !this.showModalWorkToDo;
        },

        dateTime(value) {
            return moment(value).format("ll");
        },

        // click show editor description
        handlerShowEditor() {
            this.showEditor = true;
        },

        handlerHideEditor() {
            this.showEditor = false;
        },

        // updated data current task
        updateDataTask() {
            this.taskUpdate["task_id"] = this.currentTask.id;
            delete this.currentTask.id;
            delete this.currentTask.created_at;
            delete this.currentTask.updated_at;
            delete this.currentTask.project_id;
            delete this.currentTask.dealine;
            delete this.currentTask.slug;
            delete this.currentTask.title;
            delete this.currentTask.department_id;
            delete this.currentTask.department_id;
            delete this.currentTask.card_id;
            delete this.currentTask.list_user_ids;
            this.taskUpdate["info_task"] = this.currentTask;
            this.updateTask(this.taskUpdate);
            this.showEditor = false;
        },

        // check hiden modal
        onHideModal(evt) {
            if (evt.trigger === "backdrop") {
                if (this.showEditor == true || this.showModalMember == true) {
                    evt.preventDefault();
                    this.showEditor = false;
                    this.showModalMember = false;
                } else {
                    this.showModal = false;
                }
            }
        },
    },
    created() {
        this.getListCards();
        this.getListTasks(this.$route.params.id);
    },

    mounted() {
        document.body.classList.remove("auth-body-bg");
        document.body.classList.add("page-task");
    },
};
</script>
<template>
    <pre>{{ JSON.stringify(listUsers, undefined, 4) }}</pre>
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
                        <p class="d-flex flex-row">
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
                        <div class="member">
                            <p>Thành viên</p>
                            <div class="list_user">
                                <div class="user">
                                    <img
                                        src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                        alt=""
                                    />
                                </div>
                                <div class="user">
                                    <img
                                        src="/images/avatar-1.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                        alt=""
                                    />
                                </div>
                                <div class="btn_add_user">
                                    <i class="ri-add-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="label">
                            <p>Nhãn</p>
                            <div class="list_label">
                                <div class="name_label">
                                    <div class="label_active"></div>
                                    <p>SDK</p>
                                </div>
                                <div class="btn_add_label">
                                    <i class="ri-add-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="notification">
                            <p>Thông báo</p>
                            <div class="btn_follow">
                                <i class="ri-eye-line"></i>
                                <p>Theo dõi</p>
                            </div>
                        </div>
                    </div>
                    <div :class="['content-main-detail']">
                        <h6 d-flex flex-row align-items-center><i class="ri-menu-2-line"></i>
                            <span>Mô tả</span>
                        </h6>
                        <div :class="['description']">
                            <div
                                v-if="!showEditor"
                                v-bind:innerHTML="`${
                                    currentTask.description
                                        ? currentTask.description
                                        : 'Thêm mô tả chi tiết hơn...'
                                }`"
                                :class="['content-desc']"
                                @click="handlerShowEditor()"
                            ></div>
                            <div
                                v-else="showEditor"
                                :class="['content-editor']"
                            >
                                <vue-editor
                                    id="edit-current-task"
                                    v-model="currentTask.description"
                                ></vue-editor>
                                <div class="mt-3 mb-3">
                                    <b-button
                                        variant="btn_save primary me-2"
                                        @click="updateDataTask()"
                                        >Lưu</b-button
                                    >
                                    <b-button
                                        :class="['btn_cancel']"
                                        variant="light btn_cancel"
                                        @click="handlerHideEditor()"
                                        >Hủy</b-button
                                    >
                                </div>
                            </div>
                        </div>
                        <div :class="['list-checklists']"></div>
                    </div>
                    
                    <div class="list_work_todo">
                         <div class="work-todo">
                               <div class="work-todo-header d-flex flex-row align-items-center">
                                   <p class="d-flex flex-row align-items-center name">
                                      <i class="ri-checkbox-line"></i>
                                      <span>Việc abc</span> 
                                   </p>
                                   <div class="btn_delete">Xóa</div>
                               </div>
                               <div class="work-todo-content d-flex flex-row align-items-center">
                                   <p class="percent">0%</p>
                                   <div class="progress">
                                       <div class="progress-line"></div>
                                   </div>     
                               </div>
                               <div class="btn_add">Thêm một mục</div>
                         </div>
                    </div>

                    <div :class="['content-main-detail']">
                        <h6><i class="ri-list-check"></i>Hoạt động</h6>
                        <textarea
                            class="textarea_active"
                            placeholder="Viết bình luận..."
                            v-if="!showActive"
                            @click-outside="showActive = !showActive"
                        ></textarea>
                        <div :class="['description']" v-if="showActive">
                            <div :class="['content-desc']"></div>
                            <div :class="['content-editor']">
                                <vue-editor
                                    id="edit-current-task"
                                    v-model="currentTask.description"
                                ></vue-editor>
                            </div>
                            <div class="list_button">
                                <div class="btn_save">Lưu</div>
                                <div
                                    class="btn_cancel"
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
                            <b-list-group-item @click="showModalMember=true">
                                <div class="item"> <i class="ri-user-fill"></i> Thêm thành  viên</div>
                               
                                <!-- <b-modal  size="lg" hide-footer hide-header>
                                   aaaaaaaaaa
                               </b-modal> -->
                           <div class="modalMember" v-if="showModalMember">
                                <div :class="['modalMember-header']">
                                       <span>Thành viên</span>
                                       <a  @click.stop="showModalMember =!showModalMember"><i class="ri-close-line"></i></a>
                                 </div>
                                 <input type="text" placeholder="Tìm kiếm các thành viên">
                                 <p>Thành viên của bảng</p>
                             <div class="member_of_table">
                                 <div class="list_member d-flex flex-row align-items-center">
                                     <div class="avatar">
                                        <div class="image">
                                           <img src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2" alt="">
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        placeholder="Tìm kiếm các thành viên"
                                    />
                                    <p>Thành viên của task</p>
                                    <div class="member_of_table">
                                        <div
                                            v-for="(user, index) in listUsers"
                                            :key="index++"
                                            :class="['list_member d-flex flex-row align-items-center']"
                                        >
                                            <div class="avatar">
                                                <div class="image">
                                                    <img
                                                        src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div class="name">
                                                <p>{{ user.name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_display_more"> Hiển thị các thành viên </div>
                                    <div class="member_of_table">
                                        <div
                                            v-for="(user, index) in listUsers"
                                            :key="index++"
                                            :class="['list_member d-flex flex-row align-items-center']"
                                        >
                                            <div class="avatar">
                                                <div class="image">
                                                    <img
                                                        src="/images/avatar-2.jpg?feb0f89de58f0ef9b424b1beec766bd2"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div class="name">
                                                <p>{{ user.name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </b-list-group-item>
                            <b-list-group-item @click="showModalFilter = true">
                                <div class="item">
                                    <i class="ri-price-tag-3-line"></i> Nhãn
                                </div>
                                <div class="modalFilter" v-if="showModalFilter">
                                    <div
                                        :class="[
                                            'modalFilter-header d-flex flex-row align-items-center justify-content-between',
                                        ]"
                                    >
                                        <span>Nhãn</span>
                                        <a
                                            @click.stop="
                                                showModalFilter =
                                                    !showModalFilter
                                            "
                                            ><i class="ri-close-line"></i
                                        ></a>
                                    </div>
                                    <input
                                        class="search"
                                        type="text"
                                        placeholder="Tìm nhãn"
                                    />
                                    <p>Nhãn</p>
                                    <div class="filter_of_table">
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color1">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color2">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color3">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color4">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color5">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                        <div
                                            class="list_color d-flex flex-row align-items-center"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <div class="color color6">
                                                <div class="color_child"></div>
                                            </div>
                                            <div class="btn_edit">
                                                <i class="ri-pencil-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn btn_display_more">
                                        Tạo nhãn mới
                               <div class="btn_display_more">
                                    Hiển thị các thành viên khác trong không gian làm việc
                               </div>
                           </div>
                            </b-list-group-item>
                            <b-list-group-item @click="showModalFilter=true">
                                  <div class="item"> <i class="ri-price-tag-3-line"></i> Nhãn</div>
                                  <div class="modalFilter " v-if="showModalFilter">
                                <div :class="['modalFilter-header d-flex flex-row align-items-center']">
                                       <span>Nhãn</span>
                                       <a @click.stop="showModalFilter =!showModalFilter"><i class="ri-close-line"></i></a>
                                 </div>
                                 <input class="search" type="text" placeholder="Tìm nhãn">
                                 <p>Nhãn</p>
                             <div class="filter_of_table">
                                <div class="list_color d-flex flex-row align-items-center">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <div class="color color1">
                                        <div class="color_child"></div>
                                    </div>
                                    <div class="btn_edit"><i class="ri-pencil-line"></i></div>
                                 </div>
                                 <div class="list_color d-flex flex-row align-items-center">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <div class="color color2">
                                        <div class="color_child"></div>
                                    </div>
                                    <div class="btn_edit"><i class="ri-pencil-line"></i></div>
                                 </div>
                                 <div class="list_color d-flex flex-row align-items-center">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <div class="color color3">
                                        <div class="color_child"></div>
                                    </div>
                                    <hr />
                                    <div class="btn">
                                        Bật chế độ thân thiện với người mù màu
                                    </div>
                                    <div class="btn">
                                        Gửi phản hồi cho chú tôi
                                    </div>
                                </div>
                            </b-list-group-item>
                            <b-list-group-item @click="showModalWorkToDo=true">
                                <div class="item"><i class="ri-checkbox-line"></i> Việc cần làm</div>
                                <div class="modal_work_todo" v-if="showModalWorkToDo">
                                    <div :class="[' modal_work_todo-header d-flex flex-row align-items-center justify-content-center']">
                                       <span>Thêm danh sách công việc</span>
                                       <a @click.stop="showModalWorkToDo=false"><i class="ri-close-line"></i></a>
                                    </div>
                                    <p class="title">Tiêu đề</p>
                                    <input type="text" placeholder="Việc cần làm">
                                    <div class="btn_add">Thêm</div>
                                </div>
                            </b-list-group-item>

                            <b-list-group-item
                                ><i class="ri-time-line"></i> Ngày hết
                                hạn</b-list-group-item
                            >
                            <b-list-group-item @click="showModalFile=true">
                                <div class="item">
                                    <i class="ri-attachment-2"></i> File đính kèm
                                </div>
                                <div class="modalFile" v-if="showModalFile">
                                    <div :class="['modalFile-header d-flex flex-row align-items-center justify-content-center']">
                                       <span>Đính kèm từ</span>
                                       <a @click.stop="showModalFile =!showModalFile"><i class="ri-close-line"></i></a>
                                    </div>
                                    <div class="list_upload">
                                         <div class="upload">
                                            Máy tính
                                        </div>
                                        <div class="upload">
                                            Trello
                                        </div>
                                        <div class="upload">
                                            Google Driver
                                        </div>
                                        <div class="upload">
                                            Dropbox
                                        </div>
                                        <div class="upload">
                                            Box
                                        </div>
                                        <div class="upload">
                                            OneDriver
                                        </div>
                                        
                                    </div>
                                    <hr>
                                     <div class="attach_link">
                                         <b>Đính kèm liên kết</b>
                                         <input type="text" placeholder="Dán liên kết vào đây">
                                         <div class="btn">Đính kèm</div>
                                     </div>
                                     <hr>
                                     <p class="note">Mẹo: Bạn có thể kéo thả các tập tin và liên kết vào thẻ để tải chúng lên.</p>
                       
                                </div>
                            </b-list-group-item>
                            <!-- <b-list-group-item
                                ><i class="ri-image-line"></i> Ảnh
                                bìa</b-list-group-item
                            > -->
                        </b-list-group>
                    </div>
                    <div :class="['list-item']">
                        <h6>Thao tác</h6>
                        <b-list-group>
                            <b-list-group-item
                                ><i class="ri-arrow-right-line"></i> Di
                                chuyển</b-list-group-item
                            >
                            <!-- <b-list-group-item
                                ><i class="ri-price-tag-3-line"></i> Sao
                                chép</b-list-group-item
                            >
                            <b-list-group-item
                                ><i class="ri-checkbox-line"></i>
                                share</b-list-group-item
                            > -->
                        </b-list-group>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>

    <div class="container-fluid min-vh-100">
        <PageHeader :title="title" :items="items" />
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
                            <i class="ri-more-fill"></i>
                        </template>
                        <b-dropdown-item>Edit</b-dropdown-item>
                        <b-dropdown-item>Delete</b-dropdown-item>
                    </b-dropdown>

                    <!-- end dropdown -->
                    <h4 class="card-title">{{ card.title }}</h4>
                    <p class="mb-0">3 Tasks</p>
                </div>
                <div class="card">
                    <div class="card-body border-bottom" id="item">
                        <div id="todo-task" class="task-list">
                            <draggable
                                class="list-group"
                                group="tasks"
                                :list="listTasks[card.id]"
                                @change="changeTask($event, card.id)"
                            >
                                <div
                                    class="card task-box cursor-pointer"
                                    v-for="task in listTasks[card.id]"
                                    :key="task.id"
                                    :data-cardid="card.id"
                                    @click="showTask(task.id)"
                                >
                                    <!-- <pre>{{ JSON.stringify(task, undefined, 4) }}</pre> -->
                                    <div
                                        class="progress progress-sm animated-progess"
                                        style="height: 3px"
                                    >
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 72%"
                                            aria-valuenow="72"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="list_filter">
                                           <div class="filter"></div>
                                           <div class="filter"></div>
                                           <div class="filter"></div>
                                           <div class="filter"></div>
                                           <div class="filter"></div>
                                           <div class="filter"></div>
                                        </div>
                                        <div class="float-end ml-2">
                                            <div>
                                                {{ dateTime(task.created_at) }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <a href="#" class>#{{ task.id }}</a>
                                        </div>
                                        <div>
                                            <h5 class="font-size-16">
                                                <a
                                                    href="javascript: void(0);"
                                                    class="text-dark"
                                                    >{{ task.title }}</a
                                                >
                                            </h5>
                                        </div>
                                        <div class="d-inline-flex team mb-0">
                                            <div class="me-3 align-self-center">
                                                Team :
                                            </div>
                                            <div class="team-member">
                                                <a
                                                    href="javascript: void(0);"
                                                    class="team-member d-inline-block"
                                                    v-b-tooltip.hover
                                                    data-placement="top"
                                                    title="Calvin Redrick"
                                                >
                                                    <img
                                                        src="@/assets/images/users/avatar-2.jpg"
                                                        class="rounded-circle avatar-xs"
                                                        alt
                                                    />
                                                </a>
                                            </div>
                                            <div class="team-member">
                                                <a
                                                    href="javascript: void(0);"
                                                    class="team-member d-inline-block"
                                                    v-b-tooltip.hover
                                                    data-placement="top"
                                                    title="David Martinez"
                                                >
                                                    <img
                                                        src="@/assets/images/users/avatar-1.jpg"
                                                        class="rounded-circle avatar-xs"
                                                        alt
                                                    />
                                                </a>
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
