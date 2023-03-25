<script>
import { VueDraggableNext } from 'vue-draggable-next'
import { mapGetters, mapActions, mutations } from 'vuex';
import PageHeader from "../layouts/page-header.vue";
import moment from 'moment';

export default {
    page: {
        title: "Gosu Board",
        meta: [{ name: "description" }],
    },
    components: {
        draggable: VueDraggableNext, PageHeader
    },
    data() {
        return {
            buttonAdd: {},
            newTasks: {},
            showModal: false,
            project_id: parseInt(this.$route.params.id),
            placeholder: 'Nhập tiêu đề cho thẻ này...',
            taskUpdate:{},
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
        ...mapGetters([
            'listCard',
            'listTasks',
            'currentTask',
        ])
    },
    methods: {
        ...mapActions(['createNewTask', 'getListCards', 'getListTasks', 'updateTask', 'getCurrentTask']),

        handlerClick($id) {           
            for (const key in this.listCard) {
                const cardProject = this.listCard[key];
                this.buttonAdd[cardProject.id] = false;
            }
            this.buttonAdd[$id] = true;
        },

        createTask($id) {
            this.newTasks['card_id'] = $id;
            this.newTasks['project_id'] = this.project_id;
            if (this.newTasks && this.newTasks['title_' + $id]) {
                this.createNewTask(this.newTasks);
                this.getListTasks(this.$route.params.id);
                this.newTasks = {};
            }         
        },

        changeTask(event, cardId){
            if (typeof event.added != "undefined") {
                this.taskUpdate['card_id'] = cardId;
                this.taskUpdate['task_id'] = event.added.element.id;
                this.taskUpdate['action'] = 'move_task';
                this.updateTask(this.taskUpdate);
            }
        },

        showTask(task_id){
            this.getCurrentTask(task_id);
            this.showModal = true
        },

        dateTime(value) {
            return moment(value).format('ll');
        },
    },

    created() {
        this.getListCards();
        this.getListTasks(this.$route.params.id);
    },

    mounted() {
        document.body.classList.remove("auth-body-bg");
        document.body.classList.add('page-task');
    },
};
</script>
<style>
.open-card.hide {
    display: none;
}

.open-card.show {
    display: block;
}
.list-tasks .drop-zone {
    min-height: 50px;
}

</style>
<template>
    
    <!-- <pre>{{ JSON.stringify(listCard, undefined, 4) }}</pre> -->
    <!-- <pre>{{ JSON.stringify(listTasksDemo, undefined, 4) }}</pre>
    <button @click="handlerClickaddTask()">
                                                <span> Thêm task</span>
                                            </button> -->
    <b-modal v-model="showModal" title="New Project" size="lg" hide-footer hide-header>
        <pre>{{ JSON.stringify(currentTask, undefined, 4) }}</pre>
        <div :class="['container-fluid']">
            <div :class="['row']">
                <div :class="['col-9']">
                    
                </div>
                <div :class="['col-3']">
                    <b-list-group>
                        <b-list-group-item><i class="ri-user-fill"></i> Thêm thành viên</b-list-group-item>
                        <b-list-group-item>Nhãn</b-list-group-item>
                        <b-list-group-item>Việc cần làm</b-list-group-item>
                        <b-list-group-item>Ngày hết hạn</b-list-group-item>
                        <b-list-group-item>File đính kèm</b-list-group-item>
                    </b-list-group>
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
                        <img src="@/assets/images/logo-sm-light.png" alt class="avatar-xs" />
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
                            <a href="javascript: void(0);" class="d-inline-block" v-b-tooltip.hover title="Aaron Williams">
                                <img src="@/assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt />
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="d-inline-block" v-b-tooltip.hover
                                title="Jonathan McKinney">
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">J</span>
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="d-inline-block" v-b-tooltip.hover title="Carole Connolly">
                                <img src="@/assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt />
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
            <div v-for="(card, index) in listCard" :key="index++" :class="['col-3']">
                <div class="card-body">
                    <b-dropdown right class="float-end" variant="white">
                        <template v-slot:button-content>
                            <i class="mdi mdi-dots-vertical m-0 text-muted font-size-20"></i>
                        </template>
                        <b-dropdown-item>Edit</b-dropdown-item>
                        <b-dropdown-item>Delete</b-dropdown-item>
                    </b-dropdown>

                    <!-- end dropdown -->
                    <h4 class="card-title">{{ card.title }}</h4>
                    <p class="mb-0">3 Tasks</p>
                </div>
                <div class="card">
                    <div class="card-body border-bottom">
                        <div id="todo-task" class="task-list">
                             <draggable class="list-group" group="tasks" :list="listTasks[card.id]" @change="changeTask($event, card.id)">
                                <div class="card task-box" v-for="task in listTasks[card.id]" :key="task.id" :data-cardid="card.id" @click="showTask(task.id)">
                                    <!-- <pre>{{ JSON.stringify(task, undefined, 4) }}</pre> -->
                                    <div class="progress progress-sm animated-progess" style="height: 3px">
                                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="float-end ml-2">
                                            <div>{{ dateTime(task.created_at) }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <a href="#" class>#{{ task.id }}</a>
                                        </div>
                                        <div>
                                            <h5 class="font-size-16">
                                                <a href="javascript: void(0);" class="text-dark">{{
                                                    task.title
                                                }}</a>
                                            </h5>
                                            <p class="mb-4">{{ task.description }}</p>
                                        </div>
                                        <div class="d-inline-flex team mb-0">
                                            <div class="me-3 align-self-center">Team :</div>
                                            <div class="team-member">
                                                <a href="javascript: void(0);" class="team-member d-inline-block"
                                                    v-b-tooltip.hover data-placement="top" title="Calvin Redrick">
                                                    <img src="@/assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt />
                                                </a>
                                            </div>
                                            <div class="team-member">
                                                <a href="javascript: void(0);" class="team-member d-inline-block"
                                                    v-b-tooltip.hover data-placement="top" title="David Martinez">
                                                    <img src="@/assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xs" alt />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </draggable> 
                           <!-- end task card -->
                           <div :class="[buttonAdd[card.id] ? 'show' : 'hide', 'open-card']">
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
                            <button class="btn" v-if="!buttonAdd[card.id]" @click="handlerClick(card.id)">
                                <i class="ri-add-line"></i>
                                <span> Thêm thẻ</span>
                            </button>
                            <button class="btn btn-primary mt-1 waves-effect waves-light" v-else @click="createTask(card.id)"><i
                                    class="ri-add-line"></i>
                                <span> Thêm thẻ</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</template>
