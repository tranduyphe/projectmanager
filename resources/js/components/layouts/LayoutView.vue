<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import SideBar from "./SiderBar.vue";
export default {
    components:{
        Header,
        Footer,
        SideBar,
    },

    data() { 

        return{
            showModalItem: false,
            listItem: [
            {
                image: './image/red.jpg',
                title:'PROJECT1'
            }, {
                image: './image/red.jpg',
                title:'PROJECT2'
            }, {
                image: './image/red.jpg',
                title:'PROJECT3'
            },  {
                image: './image/red.jpg',
                title:'PROJECT4'
            },
        ],

         listCard: [
            {
                image: './image/red.jpg',
                title:'PROJECT1'

            }, {
                image: './image/red.jpg',
                title:'PROJECT2'
            }, {
                image: './image/red.jpg',
                title:'PROJECT3'
            },  {
                image: './image/red.jpg',
                title:'PROJECT4'
            },  {
                image: './image/red.jpg',
                title:'PROJECT4'
            }, 

        ],
        };
       
    },

    methods:{
        onChangeIconMenu(){
                this.showModalItem=!this.item.showModalItem;
        },
    },

    
    mounted() {
        document.body.classList.remove("auth-body-bg");
        if (this.loader === true) {
        document.getElementById("preloader").style.display = "block";
        document.getElementById("status").style.display = "block";

        setTimeout(function () {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        }, 2500);
        } else {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        };
    },
};
</script>

<template>
    <div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <i class="ri-loader-line spin-icon"></i>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <Header />
            <SideBar />
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="layoutview">
                <div class="page-content">
                    <div class="layoutview-header">
                         <div class="layoutview-header-left">
                             <p class="name_project">PROJECT</p>
                             <div class="icon_star" title="Đánh hoặc bỏ đánh dấu sao bảng này. Bảng được đánh dấu sao sẽ hiện ở đầu danh sách Bảng.">
                                <i class="ri-star-line"></i>
                            </div>
                             <a class="btn_display_working_space">
                                 <div class="icon">
                                    <i class="ri-group-line"></i>
                                 </div>
                                 <p>Hiển thị không gian làm việc</p>
                             </a>
                             <a class="btn_table">
                                 <div class="icon">
                                    <i class="ri-table-alt-line"></i>
                                 </div>
                                 <p>Bảng</p>
                             </a>
                             <div class="btn_dropdown"><i class="ri-arrow-drop-down-line"></i></div>
                         </div>

                         <div class="layoutview-header-right">
                             <a class="btn_add-ons">
                                 <div class="icon">
                                    <i class="ri-rocket-2-line"></i>
                                 </div>
                                 <p>Tiện ích bổ sung</p>
                             </a>
                             <a class="btn_automation">
                                <i class="ri-flashlight-line"></i>
                                 <p>Tự động hóa</p>
                             </a>

                             <a class="btn_filter">
                                 <div class="icon"><i class="ri-filter-3-line"></i></div>
                                 <p>Lọc</p>
                             </a>
                              <div class="list_user">
                                <div class="avatar">
                                 </div>
                                <div class="avatar">
                                </div>
                                <div class="avatar">
                                </div>
                                <div class="avatar">     
                                </div>
                              </div>

                              <a class="btn_share">
                                <div class="icon"><i class="ri-user-add-line"></i></div>
                                 <p>Chia sẻ</p>
                              </a>

                              <a class="btn_menu">
                                <i class="ri-more-line"></i>
                              </a>
                        </div>
                    </div>

                    <div class="layoutview-content">
                         <div class="layoutview-list_item">
                              <div class="item" v-for="(item,index) in listItem" :key="index">
                                    <div class="modal-item-menu" v-if="showModalItem">
                                        <p>aaaaaaa</p>
                                    </div>
                                   <div class="item-header">
                                        <p class="item-header-title">
                                            Tasks
                                        </p>
                                        <div class="icon_menu" @click="onChangeIconMenu">
                                            <i class="ri-more-line"></i>
                                        </div>
                                   </div>

                                   <div class="list_card">
                                         <div class="card" v-for="(item,index) in listCard" :key="index">
                                            <div class="btn_edit"> <i class="ri-pencil-line"></i></div>
                                            <div class="progress" title="Màu sắc:xanh lá cây. Tiêu đề:abccc"></div>
                                             <div class="name-card">[Training]-Request Coding các landing page 2023-221208</div>
                                            
                                             <div class="card-list_icon">
                                                  <div class="icon_seen"><i class="ri-eye-line"></i></div>
                                                  <div class="icon_detail"><i class="ri-menu-2-fill"></i></div>
                                                  <div class="date">
                                                       <p>21 Th03 2023</p>
                                                   </div>

                                             </div>

                                             <div class="list_avatar_user_join">
                                                  <div class="avatar">
                                                  </div>
                                                  <div class="avatar">
                                                  </div>
                                                  <div class="avatar">
                                                  </div>
                                                  <div class="avatar">     
                                                  </div>
                                             </div>
                                         </div>

                                   </div>

                              
                                   

                                   <div class="list_btn">
                                        <div class="btn_add_card">
                                               <p>Thêm thẻ</p>
                                               <i class="ri-add-fill"></i>
                                        </div>

                                        <div class="btn_add_by_form" title="Tạo từ mẫu…">
                                            <i class="ri-layout-masonry-line"></i>
                                        </div>
                                   </div>
                              </div>
                            
                         </div>
                    </div>
                </div>

            
                <!-- End Page-content -->
            </div>
            <!-- end main content-->
            <!-- <Footer /> -->
        </div>
        <!-- END layout-wrapper -->
    </div>
</template>

<style lang="scss">
    // @import "~bootstrap/scss/maps";
    // @import "~bootstrap/scss/utilities";
    // @import '../../../../resources/assets/scss/app.scss';
    // @import '~@/app.scss';    
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        position: relative;
        // padding-right: 12px;
        // padding-left: 12px;
    } 
    #app{
        position: relative;
    }



    ul{
        margin: 0 !important;
      padding: 0 !important;
      list-style: none;
    }
    a{
        text-decoration:none;
    }

    p{
        margin: 0 !important;
    }

    .layoutview{
        margin-left: 241px;
        overflow: hidden;
        @media (max-width: 750px) {
            margin-left: 0;
        }
        .layoutview-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
           
            @media (max-width: 1400px) {
                flex-wrap: wrap;
               }
            .layoutview-header-left{
                display: flex;
                align-items: center;
                width: 44%;
                justify-content: flex-start;
                flex-wrap: wrap;
                @media (max-width: 1400px) {
                     width: 100%;
               }
                .name_project{
                    font-size: 18px;
                    font-weight: 700;
                   
                }
                .icon_star{
                    padding: 10px 13px;
                    background: #7e7f81;
                    cursor: pointer;
                    color: #fff;
                    font-size: 13px;
                    margin-left: 10px;
                }
                .icon_star:hover{
                    opacity: 0.6;
                    transform: scale(1.06);
                }
                .btn_dropdown{
                    cursor: pointer;
                    margin-left: 10px;
                     i{
                        font-size: 30px;
                        background: #7e7f81;
                        padding: 13% 8%;
                        color: #fff;
                     }
                }
                .btn_dropdown:hover{
                     transform: scale(1.06);
                     opacity: 0.6;
                }
                a{
                    padding: 5px 5px;
                    background: #7e7f81;
                    color: #fff;
                    text-decoration: none;
                    display:flex;
                    font-size: 14px;
                    cursor: pointer;
                    align-items: center;
                    margin-left: 10px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    i{
                        font-size: 20px;
                        
                    }
                    p{
                        margin-left: 3px !important;
                    }
                }
                a:hover{
                    opacity: 0.6;
                    transform: scale(1.06);
                }
            }

            .layoutview-header-right{
                display: flex;
                width: 57%;
                justify-content: flex-end;
                flex-wrap: wrap;
                @media (max-width: 1400px) {
                     width: 100%;
               }
                 
                .list_user{
                    display: flex;
                    align-items: center;
                    margin-left: 10px;
                    .avatar{
                        width: 40px;
                        height: 40px;
                        border-radius: 100%;
                        background: bisque;
                        margin-left: 2px;
                    }
                }

                a{
                    padding: 5px 5px;
                    background: #7e7f81;
                    color: #fff;
                    text-decoration: none;
                     display:flex;
                     align-items: center;
                     font-size: 14px;
                     cursor: pointer;
                     align-items: center;
                     margin-left: 10px;
                     text-overflow: ellipsis;
                      white-space: nowrap;
                     i{
                        font-size: 20px;
                        
                    }
                    p{
                        margin-left: 3px !important;
                    }
                }
                a:hover{
                    opacity: 0.6;
                    transform: scale(1.06);
                }
            }
        }

         .layoutview-content{
            margin-top: 45px;
            overflow-x: auto;
            padding-bottom: 20px;
             .layoutview-list_item{
                display: flex;
                .item:first-child{
                    margin-left: 10px !important;
                }
                .item{
                    width: 276px;
                    background: #e9ecef;
                    padding-bottom: 17px;
                    margin-left: 82px;
                    position: relative;
                    .modal-item-menu{
                        left: 126px;
                        position: absolute;
                        width: 154px;
                        height: 350px;
                        z-index: 3;
                        border: 1px solid;
                        background: #fff;
                    }
                    i{
                       
                        font-size: 24px;
                    }
                    .item-header{
                        display: flex;
                        width: 90%;
                        justify-content: space-between;
                        padding-left: 8%;
                        align-items: center;
                    }

                    .list_card{
                        overflow-y: scroll;
                        max-height: 520px;
                        .card{
                            width: 250px;
                            margin-inline: auto;
                            padding-left: 8px;
                            padding-bottom: 15px;
                            margin-top: 4px;
                            position: relative;

                            .btn_edit{
                                position: absolute;
                                right: 21px;
                                top: 2px;
                                display: none;
                                cursor: pointer;
                            }

                            .btn_edit:hover{
                                opacity: 0.6;
                                transform: scale(1.06);
                            }
                            .progress{
                                width: 20%;
                                background: #7bc86c;
                                margin-top: 4%;
                                margin-left: 3%;
                            }

                            .progress:hover{
                                opacity: 0.6;
                                transform: scale(1.06);
                                cursor: pointer;
                            }

                            .card-list_icon{
                                display: flex;
                                justify-content: space-around;
                                margin-top: 5px;

                                .icon_detail:hover,.icon_seen:hover{
                                    cursor: pointer;
                                    opacity: 0.6;
                                    transform: scale(1.06);
                                }
                                .date{
                                    width: 58%;
                                    p{
                                       background: beige;
                                       display: inline-block;
                                       padding: 1% 3%;
                                    }
                               }

                            }

                            .list_avatar_user_join{
                                display: flex;
                                margin-top: 5px;
                                .avatar{
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 100%;
                                    background: bisque;
                                    margin-left: 2px;
                                    
                                }
                            }

                            
                        }

                        .card:hover{
                             .btn_edit{
                                 display: block;
                                
                             }
                        }
                    }

                    .list_btn{
                        display: flex;
                        justify-content: space-around;
                        margin-top: 9px;
                        .btn_add_card{
                            display: flex;
                            width: 100px;
                            align-items: center;
                            i{
                                margin-left: 3px;
                                margin-top: 2px;
                            }
                        }

                        .btn_add_card:hover,.btn_add_by_form:hover{
                                    cursor: pointer;
                                    opacity: 0.6;
                                    transform: scale(1.06);
                                }
                    }
                }

                .item{
                    width: 276px;
                    background: #e9ecef;
                    padding-bottom: 17px;
                    .item-header{
                        display: flex;
                        width: 90%;
                        justify-content: space-between;
                        padding-left: 8%;
                    }

                    .list_card{
                        .card{
                            width: 250px;
                            margin-inline: auto;
                            padding-left: 8px;
                            padding-bottom: 15px;
                            margin-top: 20px;
                            position: relative;

                            .btn_edit{
                                position: absolute;
                                right: 21px;
                                top: 2px;
                                display: none;
                                cursor: pointer;
                            }

                            .btn_edit:hover{
                                opacity: 0.6;
                                transform: scale(1.06);
                            }
                            .progress{
                                width: 20%;
                                background: #7bc86c;
                                margin-top: 4%;
                                margin-left: 3%;
                                height: 11px;
                            }

                            .card-list_icon{
                                display: flex;
                                justify-content: space-around;
                                margin-top: 5px;

                                .icon_detail:hover,.icon_seen:hover{
                                    cursor: pointer;
                                    opacity: 0.6;
                                    transform: scale(1.06);
                                }
                                .date{
                                    width: 58%;
                                    p{
                                       background: beige;
                                       display: inline-block;
                                       padding: 1% 3%;
                                    }
                               }

                            }

                            .list_avatar_user_join{
                                display: flex;
                                margin-top: 5px;
                                .avatar{
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 100%;
                                    background: bisque;
                                    margin-left: 2px;
                                    
                                }
                            }

                            
                        }

                        .card:hover{
                             .btn_edit{
                                 display: block;
                                
                             }
                        }
                    }

                    .list_btn{
                        display: flex;
                        justify-content: space-around;
                        margin-top: 9px;
                        .btn_add_card{
                            display: flex;
                            width: 100px;
                        }

                        .btn_add_card:hover,.btn_add_by_form:hover{
                                    cursor: pointer;
                                    opacity: 0.6;
                                    transform: scale(1.06);
                                }
                    }
                }

                
             }
         }
   
    }
   
   
</style>