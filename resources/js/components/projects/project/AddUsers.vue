<script>
import { taskHelper } from "@/js/helpers/helptask";
import { taskMethods, taskGetters, projectMethods} from "@/js/store/helpers";
export default {
    props: {
        popupFiles: {
            type: Boolean,
            default: () => {
                return false
            },
        },
        projectId: {
            type: Number,
            default: () => {
                return false
            },
        },
    },
    data() {
        return {
            searchUsers : "",
            loading : false,
            path : '',
        };
    },
    computed: {
        ...taskGetters,
        resultUsers(){
            var dataUsers = this.$store.getters.listUsers ;
            const asArray = Object.values(dataUsers);
            if(this.searchUsers){
                return asArray.filter((item)=>{
                    return this.searchUsers.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                })
            }else{
                return dataUsers;
            }
        },
    },
    methods: {
        ...taskMethods,   
        ... projectMethods,
        async addUserProject(event, arr){
            if (arr) {
                if (this.projectId) {                   
                    var data = {
                        'project_id' : this.projectId,
                        'user_id' : arr['user_id'],
                        'action' : arr['action']
                    }             
                    var results = await taskHelper.addRemoveUserInProject(data); 
                    if ( arr['action'] == 'deactive') {
                        delete this.projectUsers[arr['user_id']];
                    }else{
                        if (results) {
                            this.projectUsers[arr['user_id']] = results;
                        }
                    }
                }
            }
        }    
    },
    created() {},
    mounted() {},
}
</script>
<template> 
    <div class="text-end d-flex align-items-center justify-content-end">
        <ul class="list-inline mb-0" v-if="projectUsers">
            <li class="list-inline-item" v-for="user in projectUsers">
                <a
                    href="javascript: void(0);"
                    class="d-inline-block"
                    v-b-tooltip.hover
                    :title="user.name"
                >
                    <img
                        src="@/assets/images/users/avatar-2.jpg"
                        class="rounded-circle avatar-xs"
                        alt
                    />
                </a>
            </li>
        </ul>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-plus me-1"></i>
            </button>
            <div class="dropdown-menu">
                <div><input type="text" v-model="searchUsers" placeholder="Tìm kiếm các thành viên" /></div>
                <div class="member_of_table">
                    <div
                        v-for="(user, index) in resultUsers"
                        :key="user.id"
                        :class="['list_member d-flex flex-row align-items-center']"
                        @click="addUserProject($event, {'user_id': user.id, 'action': projectUsers[user.id] ? 'deactive' : 'active'})"
                    >
                        <div class="avatar">
                            <div class="image">
                                <img
                                    src="/images/avatar-2.jpg"
                                    alt=""
                                />
                            </div>
                        </div>
                        <div class="name">
                            <p>{{ user.name }}</p>
                        </div>
                        <span
                            v-if="
                                projectUsers[user.id]
                            "
                        >
                        
                            <i class="ri-check-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
