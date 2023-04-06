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
    },
    data() {
        return {
            card_id: store.getters.currentTask.card_id,
        };
    },
    computed: {
        ...taskGetters
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

    },
    created() {
    },
    mounted() {
        
    },
}
</script>
<template>
    <p class="title">Chọn đích đến</p>
    <div class="modal_move-content">
        <div class="btn select_list">
            <p>Danh sách</p>
            <select v-model="card_id" class="mb-3"  @change="moveTask()">
                <option v-for="(card, index) in cards" :value="`${card.id}`" :key="card.id">{{ card.title }}</option>
            </select>
        </div>
    </div>
</template>