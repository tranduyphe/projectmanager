<script>
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import { store } from '@/js/store/store';
import { VueEditor } from "vue3-editor";
export default {
    components: {
        VueEditor
    },
    props: {
        popupFiles: {
            type: Boolean,
            default: () => {
                return false
            },
        },
    },
    data() {
    },
    computed: {
        ...taskGetters,
    },
    methods: {
        ...taskMethods,
        onShowModal(){ 
            this.$emit('showModalPopup', 'editor');
        },
        onHideShowModal(){ 
            this.$emit('hideModalPopup', 'editor');
        },
        async updateDataTask() {
            this.taskUpdate["task_id"] = this.currentTask.id;
            var description = {
                description: this.currentTask.description,
            };
            this.taskUpdate["info_task"] = description;
            await this.updateTask(this.taskUpdate);
            this.$emit('hideModalPopup', 'editor');
        },
    },
    created() {
    },
    mounted() {
    },
}
</script>
<template>
    <!-- {{ currentTask }} -->
    <h6 d-flex flex-row align-items-center>
        <i class="ri-menu-2-line"></i>
        <span>Mô tả</span>
    </h6>
    <div :class="['description']">
        <div
            v-if="!popupFiles"
            v-bind:innerHTML="`${
                currentTask.description
                    ? currentTask.description
                    : 'Thêm mô tả chi tiết hơn...'
            }`"
            :class="['content-desc']"
            @click="onShowModal"
        ></div>
        <div
            v-else="popupFiles"
            :class="['content-editor']"
        >
            <vue-editor
                id="edit-current-task"
                v-model="currentTask.description"
            ></vue-editor>
            <div class="mt-3 mb-3">
                <b-button
                    variant="btn_save bg-primary me-2 text-light"
                    @click="updateDataTask()"
                    >Lưu</b-button
                >
                <b-button
                    :class="['btn_cancel bg-danger text-light']"
                    variant="light btn_cancel"
                    @click="onHideShowModal"
                    >Hủy</b-button
                >
            </div>
        </div>
    </div> 
</template>