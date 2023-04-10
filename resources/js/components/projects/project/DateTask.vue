<script>
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters} from "@/js/store/helpers";
export default {
    props: {
    },
    data() {
    },
    computed: {
        ...taskGetters
    },
    methods: { 
        //updated data task
        async updateDataCurrentTask( obj ) {
            await taskHelper.updateDataTask( obj )
        },      
    },    
    created() {
    },
    mounted() {
    },
}
</script>
<template> 
    <b-list-group-item>
        <VueDatePicker    
            v-model="currentTask.deadline"                                
            :month-change-on-scroll="false"                                    
        >
            <template #trigger #action-select>
                <i class="ri-time-line"></i> Ngày hết hạn
                
            </template>
            <template #action-select="{ value }">
                <b-button variant="primary" @click="updateDataCurrentTask(
                    {
                        'key' : 'deadline',
                        'field': 'deadline',
                        'data' : value
                    }
                    )">
                    Save
                </b-button>
            </template>
        </VueDatePicker> 
    </b-list-group-item> 
</template>