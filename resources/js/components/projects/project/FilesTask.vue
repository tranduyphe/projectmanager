<script>
// import { taskMethods, taskGetters} from "../../store/helpers";
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import { store } from '@/js/store/store';
export default {
    // inject: ['publicPath'],
    props: {
        attachments: {
            type: Object,
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
            return taskHelper.dateUploadFiles(date);
        },
        async removeFiles(id){
            var task_id = this.currentTask.id
            delete this.attachments[id];
            var listids = Object.keys(this.attachments);
            var data = {
                'task_id':task_id,
                'media_id':id,
                'info_task':{'list_files': listids.join(",")}
            }
            console.log(data)
            await this.removeFilesMedia(data);
        }
    },
    created() {
    },
    mounted() {
        
    },
}
</script>
<template>
    <div>
        <h6 d-flex="" flex-row="" align-items-center="">
            <i class="ri-attachment-2"></i><span>Các tập tin đính kèm</span>
        </h6>
        <div v-if="attachments">
            <div v-for="attachment in attachments" :class="['attachment-item']">
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
        </div>
    </div>
</template>