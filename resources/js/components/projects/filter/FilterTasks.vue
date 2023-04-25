<script>
import { taskHelper } from "@/js/helpers/helptask";
import { userHelper } from "@/js/helpers/users";
import { taskMethods, taskGetters, projectMethods} from "@/js/store/helpers";
import $ from "jquery";
export default {
    props: {
        labels: {
            type: Object,
            default: () => {
                return false
            },
        },
        users: {
            type: Object,
            default: () => {
                return false
            },
        }
    },
    data() {
        return {
            filterDates: [
                {
                    value: 'no',
                    title: 'Không có ngày hết hạn',
                    class: '',
                    icon : 'ri-calendar-2-line'
                },
                {
                    value : 'out_date',
                    title : 'Quá hạn',
                    nclass: 'danger',
                    icon  : 'ri-time-line'
                },
                {
                    value: 'day_date',
                    title: 'Hết hạn vào ngày mai',
                    nclass: 'warning',
                    icon : 'ri-time-line'
                },
                {
                    value: 'week_date',
                    title: 'Hết hạn vào tuần sau',
                    nclass: '',
                    icon : 'ri-time-line'
                },
                {
                    value: 'month_date',
                    title: 'Hết hạn vào tháng sau',
                    nclass: '',
                    icon : 'ri-time-line'
                }
            ],
            filterData: {},
            nameSearch:""
        };
    },
    computed: {  
        ...taskGetters,       
    },
    methods: {
        showAvatar(url){
            return userHelper.avatar(url);
        },
        fullName(user){
            return userHelper.fullName(user);
        },
        addLabelFilter(event){
            // add user id in filter task
            try {
                if (!this.filterData['label']) {
                    this.filterData['label'] = [];
                } 
                if (!this.filterData['label']['id']) {
                    this.filterData['label']['id'] = [];
                } 
                if (event.target.checked) {
                    this.filterData['label']['id'].push(event.target.value);
                }else{
                    this.filterData['label']['id'] = this.filterData['label']['id'].filter(function(e) { return e !== event.target.value });
                    if (this.filterData['label']['id'].length == 0) {
                        delete this.filterData['label']['id'];
                    }
                    if (typeof this.filterData['label']['no'] == 'undefined' && typeof this.filterData['label']['id'] == 'undefined') {
                        delete this.filterData['label']
                    }
                }
                this.onFilter();
            } catch (error) {
                console.log(error)
            }
        },
        addUserIdFilter(event){
            // add user id in filter task
            try {
                if (!this.filterData['users']) {
                    this.filterData['users'] = [];
                } 
                if (!this.filterData['users']['list_user']) {
                    this.filterData['users']['list_user'] = [];
                } 
                if (event.target.checked) {
                    this.filterData['users']['list_user'].push(event.target.value);
                    $('#checkAllUsers').prop('checked',true)
                }else{
                    this.filterData['users']['list_user'] = this.filterData['users']['list_user'].filter(function(e) { return e !== event.target.value });
                    if (this.filterData['users']['list_user'].length == 0) {
                        delete this.filterData['users']['list_user'];
                        $('#checkAllUsers').prop('checked',false)
                    }
                    if (typeof this.filterData['users']['no'] == 'undefined' && typeof this.filterData['users']['list_user'] == 'undefined') {
                        delete this.filterData['users']
                    }
                }                
                this.onFilter();
            } catch (error) {
                console.log(error)
            }
        },
        onFilter(){
            this.$emit('filterTask',this.filterData);            
        },
        onSearch(e){
            if (e.target.value) {
                this.filterData['search'] = e.target.value;
            }else{
                delete this.filterData['search']
            }
            this.onFilter();
        }
    },
    watch: {
    },
    created() {
    },
    mounted() {
        $(this.$refs.myFilter).on('click', function(evt){ 
            // if ($(this).find('.item-dropdown .dropdown-menu').hasClass('show')) {
            //     $(this).find('.item-dropdown .dropdown-menu').dropdown('toggle')
            // }
            evt.stopPropagation();
        })
        const ref = this
        const elementCheckBox = $(this.$refs.myFilter.querySelectorAll('.checkbox'))
        elementCheckBox.click(function(evt){ 
            var $this = $(this).find('input[type="checkbox"]');
            const nameValue = $this.val();
            const nameAttr = $this.attr('name');
            if (nameAttr == 'user') { 
                if (typeof ref.filterData['users'] == 'undefined') {
                    ref.filterData['users'] = []
                }          
                if($this.is(':checked')) { 
                    $this.prop('checked',true);
                    if (nameValue == 'no') {
                        ref.filterData['users']['no'] = nameValue;
                    }else{
                        // add list user in filter
                        if (typeof ref.filterData['users']['list_user'] == 'undefined') {
                            ref.filterData['users']['list_user'] = [];
                        }   
                        var childrenElement = $this.parents('.item').find('.list-user input[type="checkbox"]');
                        childrenElement.each(function (index, element) {
                            ref.filterData['users']['list_user'].push( this.value )
                            $(this).prop('checked',true);                            
                        });                   
                    }
                }else{
                    if (ref.filterData['users'].length > 0) {
                        ref.filterData['users'] = ref.filterData['users'].filter(function(e) { 
                            return e != nameValue
                        })
                    }
                    $this.prop('checked',false);
                    if (nameValue == 'no') {
                        delete ref.filterData['users']['no'];                        
                    }else{
                        delete ref.filterData['users']['list_user'];
                        var childrenElement = $this.parents('.item').find('.list-user input[type="checkbox"]');
                        childrenElement.each(function (index, element) {
                            $(this).prop('checked',false);                            
                        }); 
                    }
                    if (typeof ref.filterData['users']['no'] == 'undefined' && typeof ref.filterData['users']['list_user'] == 'undefined') {
                        delete ref.filterData['users']
                    }
                }
            }    

            // add date in filter
            if (nameAttr == 'date') {
                if (typeof ref.filterData['date'] == 'undefined') {
                    ref.filterData['date'] = []
                }
                if($this.is(':checked')) { 
                    $this.parents('.list').find('input[type="checkbox"]').prop('checked',false); 
                    $this.prop('checked',true);
                    ref.filterData['date'] = nameValue
                }else{
                    $(this).prop('checked',false); 
                    delete ref.filterData['date'];
                }
            }

            // label in filter
            if (nameAttr == 'label') {
                if (typeof ref.filterData['label'] == 'undefined') {
                    ref.filterData['label'] = []
                }
                if($this.is(':checked')) { 
                    $this.prop('checked',true);
                    if (nameValue == 'no') {
                        ref.filterData['label']['no'] = nameValue 
                    }
                }else{
                    $(this).prop('checked',false); 
                    if (nameValue == 'no') {
                        delete ref.filterData['label']['no'] 
                    }
                    if (typeof ref.filterData['label']['no'] == 'undefined' && typeof ref.filterData['label']['id'] == 'undefined') {
                        delete ref.filterData['label']
                    }
                }
            }
            ref.onFilter();
        }); 
        
         
    },
}
</script>
<template> 
    <div class="text-end d-flex align-items-center justify-content-end">
        <div class="btn-group">
            <button type="button" class="btn_filter dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="icon icon-close"><i class="ri-filter-3-line"></i></span>
                <span>Lọc</span>
            </button>
            <div class="dropdown-menu dropdown_add_user" ref="myFilter" id="myFilter">
                <div>
                    <div class="modal_move-header d-flex flex-row align-items-center justify-content-center"><span>Lọc</span><a><i class="ri-close-line"></i></a></div>
                </div>
                <div class="item-dropdown">
                    <span>Từ khóa</span>
                    <input type="text" @input="onSearch" placeholder="Nhập từ khóa" />
                </div>
                <div class="item-dropdown">
                    <span>Ngày hết hạn</span>
                    <ul class="list">
                        <li v-for="data in filterDates" :class="[data.nclass , 'item']">
                            <span class="checkbox">
                                <input type="checkbox" name="date" :value="data.value">
                            </span>
                            <span :class="data.class">
                                <span class="icon"><i :class="data.icon"></i></span>
                                {{ data.title }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="item-dropdown">
                    <span>Nhãn</span>
                    <ul class="list">
                        <li class="item">
                            <span class="checkbox">
                                <input type="checkbox" name="label" :value="'no'">
                            </span>
                            <span>
                                <i class="ri-price-tag-3-line"></i>
                                <span>Không có Nhãn</span>
                            </span>
                        </li>   
                        <li class="item" v-for="label in labels">
                            <span class="checkbox">
                                <input type="checkbox" :name="'label'" :value="label.id" @click="addLabelFilter">
                            </span>
                            <span class="name">{{ label.name }}</span>
                        </li> 
                    </ul>
                </div>
                <div class="item-dropdown">
                    <span>Thành viên</span> 
                    <ul class="list">
                        <li class="item">
                            <span class="checkbox">
                                <input class="input" type="checkbox" name="user" :value="'no'">
                            </span>
                            <span>
                                <i class="ri-price-tag-3-line"></i>
                                <span>Không có thành viên</span>
                            </span>
                        </li>  
                        <li class="item">
                            <span class="checkbox">
                                <input class="input" type="checkbox" id="checkAllUsers" name="user" :value="'check'">
                            </span>
                            <span>
                                <button type="button" class="btn_filter dropdown-toggle">
                                    <span>Chọn thành viên</span>
                                    <span class="icon icon-down"><i class="ri-arrow-down-s-line"></i></span>
                                </button>
                                <!-- <div class="dropdown-menu"> -->
                                    <ul class="list-user">
                                        <li class="item" v-for="user in users">
                                            <span>
                                                <input class="input" type="checkbox" name="choose_user" :value="user.id" @click="addUserIdFilter">
                                                {{ `${fullName(user)}` }}
                                            </span>
                                            <!-- <span class="name">
                                                <img
                                                    :src="`${showAvatar(user.avatar)}`"
                                                    :alt="`${fullName(user)}`"
                                                    :title="`${fullName(user)}`" 
                                                />
                                                {{ `${fullName(user)}` }}
                                            </span> -->
                                        </li> 
                                    </ul>
                                <!-- </div> -->
                            </span>
                        </li>                        
                    </ul>                   
                </div>
                
            </div>
        </div>
    </div>
</template>