<script>
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
export default {
    props: {
        popupFiles: {
            type: Boolean,
            default: () => {
                return false
            },
        },
    },
    data() {
        return {
        };
    },
    computed: {
        ...taskGetters,
    },
    methods: {
        ...taskMethods,      
    },
    created() {
    },
    mounted() {
    },
}
</script>
<template>  
    <div class="member" v-if="currentTask.members">
        <p>Thành viên</p>
        <div :class="['d-flex align-items-center']">
            <div class="list_user">
                <div
                    class="user"
                    v-for="(
                        userTask, index
                    ) in currentTask.members"
                    :key="index"
                >
                    <img
                        src="/images/avatar-2.jpg"
                        :title="userTask.name"
                    />
                </div>
            </div>
            <!-- <div
                class="btn_add_user d-flex align-items-center justify-content-center ms-2"
            >
                <i class="ri-add-line"></i>
            </div> -->
        </div>
    </div>
</template>
