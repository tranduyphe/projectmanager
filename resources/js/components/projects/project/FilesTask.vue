<script>
// import { taskMethods, taskGetters} from "../../store/helpers";
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
import { store } from '@/js/store/store';
export default {
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
        };
    },
    computed: {
        ...taskGetters
    },
    methods: {
        ...taskMethods,

    },
    created() {
        var publicPath = "{{ asset('') }}";
        console.log(publicPath);
    },
    mounted() {
        // console.log(public_path('uploads'))
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
                </div>
                <div v-else-if="attachment.type === 'pdf'">
                    <a :href="attachment.name_file">
                        <span>{{ attachment.type }}</span>
                    </a>
                </div>
                <!-- 
                <div v-else-if="attachment.type === 'png' || attachment.type === 'jpg' || ttachment.type === 'jpeg'">
                    <a :href="attachment.name_file">
                        <img src="{{ public_path('uploads')+attachment.name_file }}" :alt="attachment.title">
                    </a>
                </div> -->
                <div v-else>
                    <a :href="attachment.name_file" :target="['_blank']">
                        <span>{{ attachment.type }}</span>
                    </a>
                </div>
                <pre>{{ attachment }}</pre>
            </div>
        </div>
    </div>
</template>