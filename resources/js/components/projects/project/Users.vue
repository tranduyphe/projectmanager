<script>
import { taskHelper } from "@/js/helpers/helptask";
import { userHelper } from "@/js/helpers/users";
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
            searchUsers : "",
            users : false
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
        onShowModal(){ 
            this.$emit('showModalPopup', 'user');
        },
        onHideShowModal(){ 
            this.searchUsers = "",
            this.$emit('hideModalPopup', 'user');
        },
        //updated data task
        async updateDataCurrentTask( obj ) {
            await taskHelper.updateDataTask( obj )
        }, 
        showAvatar(url){
            return userHelper.avatar(url);
        },
        fullName(user){
            return userHelper.fullName(user);
        }         
    },
    created() {
    },
    mounted() {
    },
}
</script>
<template>  
    <b-list-group-item>
        <div class="item" @click="onShowModal">
            <i class="ri-user-fill"></i> Thêm thành viên
        </div>
        <div class="modalMember" v-if="popupFiles">
            <div :class="['modalMember-header']">
                <span>Thành viên</span>
                <a @click="onHideShowModal"
                    ><i class="ri-close-line"></i
                ></a>
            </div>
            <input type="text" v-model="searchUsers" placeholder="Tìm kiếm các thành viên" />
            <p>Thành viên của task</p>
            <div class="member_of_table">
                <div
                    v-for="(user, index) in resultUsers"
                    :key="user.id"
                    :class="['list_member d-flex flex-row align-items-center w-100']"
                    @click="
                        updateDataCurrentTask({
                            action: currentTask.members
                                ? !currentTask.members[user.id]
                                    ? 'active'
                                    : 'deactive'
                                : 'active',
                            id: user.id,
                            data: user,
                            key: 'members',
                            field: 'list_user_ids',
                        })
                    "
                    :data-check="`${
                        currentTask.members
                            ? !currentTask.members[user.id]
                                ? 'active'
                                : 'deactive'
                            : 'active'
                    }`"
                >
                    <div class="avatar">
                        <div class="image">
                            <img
                                :src="`${showAvatar(user.avatar)}`"
                                :alt="`${fullName(user)}`"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="name">
                            <p>{{ user.name }}</p>
                        </div>
                        <span
                            v-if="
                                currentTask.members &&
                                currentTask.members[user.id]
                            "
                        >
                        
                            <i class="ri-check-line"></i>
                        </span>
                    </div> 
                </div>
            </div>
        </div>
    </b-list-group-item>
</template>
