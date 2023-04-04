<script>
import { mapGetters, mapActions, mutations } from "vuex";
import { VueEditor } from "vue3-editor";
export default {
    components: {
        VueEditor,
    },
    data() {
        return {
            projectData: this.$store.getters.projectData,
            authData: this.$store.getters.getAuthUserData,
            loading: false,
            show: false,
        };
    },
    computed: {
        ...mapGetters(["listProjects", "authUserData"]),
    },
    methods: {
        ...mapActions(["getProjects", "createProject", "auth"]),
        showModal() {
            this.show = true;
        },

        addProject() {
            this.createProject(this.projectData);
            this.show = false;
        },

        resetForm() {
            this.projectData = {};
        },

        getDataProject() {},
    },
    created() {
        this.auth();
        this.getProjects();
    },
    mounted() {
        // console.log(this.listProjects);
    },
};
</script>
<template>
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div
                    v-if="
                        authUserData.roles[0].name === 'manager' ||
                        authUserData.roles[0].name === 'administrator'
                    "
                >
                    <b-modal
                        v-model="show"
                        title="New Project"
                        size="xl"
                        @hidden="resetForm"
                        hide-footer
                    >
                        <form @submit.prevent="addProject">
                            <b-form-group
                                label="Title Project"
                                label-for="title-input"
                            >
                                <b-form-input
                                    id="title-project"
                                    v-model="projectData.title"
                                    required
                                >
                                </b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Description"
                                label-for="title-input"
                            >
                                <vue-editor
                                    v-model="projectData.description"
                                ></vue-editor>
                            </b-form-group>
                            <b-form-group
                                label="Start Date"
                                label-for="datetime-picker"
                            >
                                <VueDatePicker
                                    required
                                    v-model="projectData.start_time"
                                    auto-apply
                                    :month-change-on-scroll="false"
                                />
                            </b-form-group>
                            <b-form-group
                                label="End Date"
                                label-for="datetime-picker"
                            >
                                <VueDatePicker
                                    required
                                    v-model="projectData.end_time"
                                    auto-apply
                                    :month-change-on-scroll="false"
                                />
                            </b-form-group>
                            <div :class="['modal-footer']">
                                <b-button type="submit" variant="primary"
                                    >Create</b-button
                                >
                            </div>
                        </form>
                    </b-modal>
                    <b-button variant="primary" @click="showModal"
                        >Add new project</b-button
                    >
                </div>

                <div class="authentication-page-content p-4 d-flex min-vh-100">
                    <div class="w-100">
                        <div class="recently-viewed">
                            <div class="recently-viewed-content">
                                <ul :class="['list_item']">
                                    <li
                                        v-for="(project, index) in listProjects"
                                        :class="['item mb-5']"
                                    >
                                        <router-link
                                            :to="{
                                                name: 'viewproject',
                                                params: { id: project.id },
                                            }"
                                            class="p-1 mr-1 cursor-pointer"
                                        >
                                            <p>{{ project.title }}</p>
                                        </router-link>
                                        <div class="item-icon">
                                            <div
                                                class="icon-active"
                                                title="Có hoạt động mới trong bảng này."
                                            ></div>
                                            <div
                                                class="icon-star"
                                                title="Bấm để gắn dấu sao bảng này. Bảng này sẽ được thêm vào danh sách được đánh dấu sao của bạn."
                                            >
                                                <i class="ri-star-line"></i>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</template>
<style lang="scss">
ul {
    margin: 0 !important;
    padding: 0 !important;
    list-style: none;
}
a {
    text-decoration: none;
}

p {
    margin: 0 !important;
}

.main-content {
    // margin-left: 260px;
    // overflow: hidden;
    // width: 75%;
    // @media (max-width: 992px) {
    //     width: 85% !important;
    //     padding-left: 15%;
    // }
    // @media (max-width: 750px) {
    //     width: 95% !important;
    //     padding-left: 5%;
    //     font-size: 13px;
    // }

    .page-content {
        // margin-left: 35px;
        // max-width: 1623px;
        // width: 100%;
        // margin-left: 0%;
        .recently-viewed-title {
            display: flex;
            align-items: center;
            i {
                font-size: 20px;
            }
            p {
                padding-left: 9px;
            }
        }
        .recently-viewed-content {
            margin-top: 2%;
        }
        .list_item {
            display: flex;
            flex-wrap: wrap;
            @media (max-width: 992px) {
                column-gap: 2%;
                row-gap: 3vw;
            }
            .item:hover {
                opacity: 0.6;
                transform: scale(1.06);
            }
            .item {
                width: 23%;
                margin-left: 2%;
                background: #abbfbf;
                height: 150px;
                cursor: pointer;
                position: relative;
                @media (max-width: 992px) {
                    width: 47%;
                }
                @media (max-width: 750px) {
                    height: 100px;
                }

                a {
                    text-decoration: none !important;
                    p {
                        width: 100%;
                        height: 150px;
                        padding: 6% 8%;
                        color: #fff;
                        background: #abbfbf;
                        @media (max-width: 750px) {
                            height: 100px;
                        }
                    }
                }
                .item-icon {
                    display: flex;
                    position: absolute;
                    bottom: 5%;
                    right: 4%;
                    align-items: center;
                    .icon-active {
                        background: #fff;
                        width: 20px;
                        height: 20px;
                        border-radius: 100%;
                    }
                    .icon-star {
                        margin-left: 5px;
                        display: none;
                    }
                }
            }
            .item:hover {
                .icon-star {
                    display: block !important;
                }
            }
        }

        .working_space {
            margin-top: 4%;
            padding-bottom: 4%;
            p {
                font-weight: 700;
                color: #5e6c84;
            }

            .working_space-container:first-child.working_space-header {
                margin-top: 4% !important;
            }

            .working_space-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 97%;
                margin-top: 4%;
                @media (max-width: 750px) {
                    flex-wrap: wrap;
                    margin-top: 12%;
                }
                .logo {
                    width: 19%;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    @media (max-width: 992px) {
                        width: 25%;
                    }
                    @media (max-width: 750px) {
                        width: 45%;
                    }
                    .avatar {
                        width: 33%;
                        height: 4.5vw;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 2vw;
                        background: antiquewhite;
                        @media (max-width: 750px) {
                            height: 9.5vw;
                            font-size: 5vw;
                        }
                        p {
                            margin: 0;
                        }
                    }
                    .name {
                        width: auto;
                    }
                }

                .list_options {
                    display: flex;
                    width: 70%;
                    justify-content: space-between;
                    column-gap: 2%;
                    @media (max-width: 992px) {
                        flex-wrap: wrap;
                        column-gap: 2vw;
                        row-gap: 2vw;
                        justify-content: center;
                    }
                    @media (max-width: 750px) {
                        width: 100%;
                        justify-content: flex-start;
                    }
                    .list_options-item:hover {
                        opacity: 0.6;
                        transform: scale(1.06);
                        cursor: pointer;
                    }
                    .list_options-item {
                        background: #f0f2f5;
                        padding: 2% 3%;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        color: black;
                        text-decoration: none;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        overflow: hidden;
                        @media (max-width: 992px) {
                            width: 45%;
                        }
                        i {
                            font-size: 20px;
                        }
                        p {
                            margin: 0;
                            margin-left: 3px !important;
                        }
                    }

                    .list_options-item:nth-child(5) {
                        background: #eddbf4;
                    }
                }
            }

            .working_space-content {
                display: flex;
                margin-top: 2%;
                width: 48%;
                justify-content: space-between;
                @media (max-width: 992px) {
                    width: 70%;
                }
                @media (max-width: 750px) {
                    width: 100%;
                    margin-top: 4%;
                }
                .working_space-content-item:hover {
                    opacity: 0.6;
                    transform: scale(1.06);
                    cursor: pointer;
                    .icon-star {
                        display: block !important;
                    }
                }
                .working_space-content-item {
                    width: 47%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 150px;
                    background: antiquewhite;
                    position: relative;
                    @media (max-width: 750px) {
                        height: 100px;
                    }
                    a {
                        display: block;
                        width: 100%;
                        height: 150px;
                        text-decoration: none;
                        @media (max-width: 750px) {
                            height: 100px;
                        }
                        p {
                            padding-top: 6%;
                            padding-left: 9%;
                            color: #fff;
                        }
                    }

                    .item-icon {
                        display: flex;
                        position: absolute;
                        bottom: 5%;
                        right: 4%;
                        align-items: center;
                        .icon-active {
                            background: #fff;
                            width: 20px;
                            height: 20px;
                            border-radius: 100%;
                        }
                        .icon-star {
                            margin-left: 5px;
                            display: none;
                        }
                    }
                }
                .working_space-content-create:hover {
                    opacity: 0.6;
                    transform: scale(1.06);
                    cursor: pointer;
                }
                .working_space-content-create {
                    width: 48%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 150px;
                    background: aliceblue;
                    @media (max-width: 750px) {
                        height: 100px;
                    }
                }
            }
        }
        .view_table_close:hover {
            opacity: 0.6;
            transform: scale(1.06);
            cursor: pointer;
        }

        .view_table_close {
            width: 30%;
            background: aliceblue;
            text-align: center;
            padding: 15px 0;
            width: 259px;
        }
    }
}
</style>
