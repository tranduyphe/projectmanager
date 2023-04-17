<script>
// import { taskMethods, taskGetters} from "../../store/helpers";
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import { store } from '@/js/store/store';
export default {
    props: {
        cards: {
            type: Object,
            default: () => {
                return {}
            },
        },
        popupFiles: {
            type: Boolean,
            default: () => {
                return false
            },
        },
    },
    data() {
        return {
            card_id: store.getters.currentTask.card_id,
        };
    },
    computed: {
        ...taskGetters,
        // card_id(){
        //     return this.currentTask.card_id
        // }
    },
    methods: {
        ...taskMethods,
        async moveTask(e, card_id) {
            e.stopPropagation();
            var oldCardId = this.currentTask.card_id;
            var taskId    = this.currentTask.id;
            var newCardId = card_id;
            if (oldCardId != newCardId) {
                this.listTasks[taskId]['card_id'] = newCardId;
                var listOldCards = this.listTaskDraggable[oldCardId];
                var listNewCards = listOldCards.filter(v => v !== taskId);
                var data = {
                    'task_id' : taskId,
                    'info_task' : {
                        'card_id': newCardId
                    }
                }
                await this.updateTask(data);
                this.listTaskDraggable[oldCardId] = listNewCards;
                if (typeof this.listTaskDraggable[newCardId] == 'undefined') {
                    this.listTaskDraggable[newCardId] = [];
                }
                this.listTaskDraggable[newCardId].push(taskId);
            }
        },
    },
    created() {
        // console.log(this.card_id)
        // console.log(this.currentTask)
    },
    mounted() {
    },
}
</script>
<template>
    <h6>Thao tác</h6>
    <b-list-group>
        <b-list-group-item>
            <div class="btn-group">
                <button type="button" class="item btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-arrow-right-line" role="button"></i>
                    Di chuyển
                </button>
                <div class="dropdown-menu modal_move">
                    <div class="modal_move-header d-flex flex-row align-items-center justify-content-center"><span>Di chuyển thẻ</span><a><i class="ri-close-line"></i></a></div>
                    <h6 class="title">Chọn đích đến</h6>
                    <div class="modal_move-content">
                        <div class="btn select_list">
                            <p>Danh sách</p>
                            <div role="button" v-for="(card, index) in cards" :class="[`${currentTask.card_id == card.id ? 'active' : ''}`,'dropdown-item']" @click="moveTask($event, card.id)">
                                {{ card.title }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-list-group-item>
    </b-list-group>
</template>