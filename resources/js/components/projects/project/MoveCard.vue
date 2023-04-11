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
        async moveTask() {
            var oldCardId = this.currentTask.card_id;
            var taskId    = this.currentTask.id;
            var newCardId = this.card_id;
            if (oldCardId != newCardId) {
                this.listTasks[taskId]['card_id'] = newCardId;
                var listOldCards = this.listTaskDraggable[oldCardId];
                var listNewCards = listOldCards.filter(v => v !== taskId);
                this.listTaskDraggable[oldCardId] = listNewCards;
                if (typeof this.listTaskDraggable[newCardId] == 'undefined') {
                    this.listTaskDraggable[newCardId] = [];
                }
                this.listTaskDraggable[newCardId].push(taskId);
                var data = {
                    'task_id' : taskId,
                    'info_task' : {
                        'card_id': newCardId
                    }
                }
                await this.updateTask(data);
            }
        },
        onShowModal(){ 
            this.$emit('showModalPopup', 'move');
        },
        onHideShowModal(){ 
            this.$emit('hideModalPopup', 'move');
        },
    },
    created() {
    },
    mounted() {
    },
}
</script>
<template>
    <h6>Thao tác</h6>
    <b-list-group>
        <b-list-group-item>
            <div class="item" @click="onShowModal">
                <i class="ri-arrow-right-line"></i>
                Di chuyển
            </div>
            <div class="modal_move" v-if="popupFiles">
                <div
                    :class="[
                        ' modal_move-header d-flex flex-row align-items-center justify-content-center',
                    ]"
                >
                    <span>Di chuyển thẻ</span>
                    <a @click="onHideShowModal"
                        ><i class="ri-close-line"></i
                    ></a>
                </div>
                <p class="title">Chọn đích đến</p>
                <div class="modal_move-content">
                    <div class="btn select_list">
                        <p>Danh sách</p>
                        <select v-model="card_id" class="mb-3"  @change="moveTask()">
                            <option v-for="(card, index) in cards" :value="`${card.id}`" :key="card.id" :selected="card.id === 3">{{ card.title }}</option>
                        </select>
                    </div>
                </div>                                  
            </div>
        </b-list-group-item>
    </b-list-group>
</template>