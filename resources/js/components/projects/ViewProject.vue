<script>
import { VueDraggableNext } from 'vue-draggable-next'
import { mapGetters, mapActions, mutations } from 'vuex';
export default {
    components: {
        draggable: VueDraggableNext,
    },
    data() {
        return {
            buttonAdd: {},
            newTasks: {},
            project_id: parseInt(this.$route.params.id),
            textarea: {
                placeholder: 'Nhập tiêu đề cho thẻ này...',
            },
            taskUpdate:{},
        };
    },
    computed: {
        ...mapGetters([
            'listCard',
            'listTasks',
        ])
    },
    methods: {
        ...mapActions(['createNewTask', 'getListCards', 'getListTasks', 'updateTask']),

        handlerClick($id) {
            for (const key in this.singeProject.card) {
                const cardProject = this.singeProject.card[key];
                this.buttonAdd[cardProject.id] = false;
            }
            this.buttonAdd[$id] = true;
        },
        // handlerClickaddTask() {
        //     this.$store.dispatch('updatedDataTasks', { name: 'New Item', price: 10 })
        // },

        createTask($id) {
            this.newTasks['card_id'] = $id;
            this.newTasks['project_id'] = this.project_id;
            if (this.newTasks && this.newTasks['title_' + $id]) {
                this.createNewTask(this.newTasks);
                this.getListTasks(this.$route.params.id);
            }         
        },

        changeTask(event, cardId){
            if (typeof event.added != "undefined") {
                this.taskUpdate['card_id'] = cardId;
                this.taskUpdate['task_id'] = event.added.element.id;
                this.taskUpdate['action'] = 'move_task';
                this.updateTask(this.taskUpdate);
            }
        }
    },

    created() {
        this.getListCards();
        this.getListTasks(this.$route.params.id);
    },

    mounted() {
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
    <!-- <pre>{{ JSON.stringify(listTasksDemo, undefined, 4) }}</pre>
    <button @click="handlerClickaddTask()">
                                                <span> Thêm task</span>
                                            </button> -->
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div v-for="(card, index) in listCard" :key="index++" :class="['col-3']">
                                        <h6 class="title-card">
                                            {{ card.title }}
                                        </h6>
                                        <div class="list-tasks">
                                            <draggable 
                                                v-model="listTasks[card.id]" 
                                                group="tasks" 
                                                transition="100" 
                                                class="drop-zone" 
                                                @change="changeTask($event, card.id)"
                                            >
                                                <transition-group>
                                                    <div v-for="task in listTasks[card.id]" :key="task.id" :data-cardid="card.id" >{{task.title}}</div>
                                                </transition-group>
                                            </draggable>
                                        </div>
                                        <div :class="[buttonAdd[card.id] ? 'show' : 'hide', 'open-card']">
                                            <textarea v-model="newTasks['title_' + card.id]" :name="'card_id_' + card.id"
                                                :id="card.id" cols="30" rows="2"></textarea>
                                        </div>
                                        <button v-if="!buttonAdd[card.id]" @click="handlerClick(card.id)">
                                            <i class="ri-add-line"></i>
                                            <span> Thêm thẻ</span>
                                        </button>
                                        <button class="btn btn-primary" v-else @click="createTask(card.id)"><i
                                                class="ri-add-line"></i>
                                            <span> Thêm thẻ</span>
                                        </button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
