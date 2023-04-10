<script>
// import { taskMethods, taskGetters} from "../../store/helpers";
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import { store } from '@/js/store/store';
import FileUploads from "./UploadFiles.vue";
export default {
    // inject: ['publicPath'],
    components: {
        FileUploads
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
        return {
            card_id: store.getters.currentTask.card_id,
            publicPath: 'http://localhost/projectmanager/public/uploads/'
        };
    },
    computed: {
        ...taskGetters
    },
    methods: {
        ...taskMethods,
        convertDate(date){
            return taskHelper.convertDate(date);
        },
        async removeFiles(id){
            var task_id = this.currentTask.id;
            delete this.currentTask['list_files'][id];           
            var listids = Object.keys(this.currentTask['list_files']);            
            var data = {
                'task_id':task_id,
                'media_id':id,
                'info_task':{'list_files': listids ? listids.join(",") : "" }
            }
            delete this.listTasks[task_id]['list_files'][id];
            if ( Object.keys(this.currentTask['list_files']).length == 0) {
                this.currentTask['list_files'] = false;
            }
            await this.removeFilesMedia(data);
            
        },
        // hidden modal 
        hideModalPopup(data){
            this.$emit('hideModalPopup', 'files1')
        },
        // hidden modal 
        showModalPopup(data){
            this.$emit('showModalPopup', 'files1')
        },
    },
    created() {
    },
    mounted() {
        
    },
}
</script>
<template>
    <div>
        
        <div v-if="currentTask.list_files">
            <h6 d-flex="" flex-row="" align-items-center="">
                <i class="ri-attachment-2"></i><span>Các tập tin đính kèm</span>
            </h6>
            <div v-for="attachment in currentTask.list_files" :class="['attachment-item']">
                <div v-if="attachment.type === 'link'">
                    <a :href="attachment.name_file" :target="['_blank']">
                        <span><i class="ri-attachment-2"></i></span>
                    </a>
                    <p>
                        <strong>{{ attachment.title }}</strong>
                        <div>
                            <span>{{ convertDate(attachment.updated_at) }}</span>
                            <b-button variant="danger" @click="removeFiles(attachment.id)">Xóa</b-button>
                        </div>
                    </p>
                </div>
                <div v-else-if="attachment.type === 'pdf'">
                    <a :href="publicPath+attachment.name_file">
                        <span>{{ attachment.type }}</span>
                    </a>
                    <div>
                        <strong>{{ attachment.title }}</strong>
                        <div>
                            <span>{{ convertDate(attachment.updated_at) }}</span>
                            <b-button variant="danger"  @click="removeFiles(attachment.id)">Xóa</b-button>
                        </div>
                    </div>
                </div>
                
                <div v-else-if="attachment.type === 'png' || attachment.type === 'jpg' || attachment.type === 'jpeg'">
                    <a :href="attachment.name_file">
                        <img :src="publicPath+attachment.name_file" :alt="attachment.title">
                    </a>
                    <p>
                        <strong>{{ attachment.title }}</strong>
                        <div>
                            <span>{{ convertDate(attachment.updated_at) }}</span>
                            <b-button variant="danger" @click="removeFiles(attachment.id)">Xóa</b-button>
                        </div>
                    </p>
                </div>
                <div v-else>
                    <a :href="publicPath+attachment.name_file" :target="['_blank']">
                        <span>{{ attachment.type }}</span>
                    </a>
                    <p>
                        <strong>{{ attachment.title }}</strong>
                        <div>
                            <span>{{ convertDate(attachment.updated_at) }}</span>
                            <b-button variant="danger" @click="removeFiles(attachment.id)">Xóa</b-button>
                        </div>
                    </p>
                </div>
            </div>
            <FileUploads @showModalPopup = "showModalPopup" @hideModalPopup = "hideModalPopup" :popupFiles="popupFiles"></FileUploads>
        </div>
    </div>
</template>