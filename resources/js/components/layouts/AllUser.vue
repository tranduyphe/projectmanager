<template>
  <div class="user_manager">
    <div class="row position-relative">
      <div class="col-md-12">
        <div class="card show border border-0">
          <button ref="myModalAddUserBtn" type="button" class="btn btn-all-add-edit my-3 mx-3 position-absolute btn-primary"
            data-bs-toggle="modal" data-bs-target="#ModalAddUser">
            Add user
          </button>
          <div class="card-body">
            <h4 class="card-title text-md-center fs-4 my-3 text-right">
              User Manager
            </h4>
            <div class="table-responsive-lg">
              <table ref="myTable" class="table table-bordered table-striped table-hover display nowrap"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <button ref="myModalBtn" type="button" class="btn btn-primary d-none" data-bs-toggle="modal"
      data-bs-target="#exampleModal">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog p-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="word_default p-4">
            <h3 class="text-center">Change Roles</h3>
            <div class="col-md-12 d-flex flex-column align-items-center">
              <form @submit.prevent="updateRolesUser" class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" placeholder="Enter description" class="form-control mt-1" v-model="userForm.email"
                        disabled required />
                    </div>
                    <div class="form-group mt-3">
                      <label>Username</label>
                      <input type="text" placeholder="Enter description" class="form-control mt-1" v-model="userForm.name"
                        required disabled />
                    </div>
                    <div class="mt-3">
                      <div v-if="showCheckbox" class="form-check" v-for="(role, index) in roles"
                      :key="`checkbox_${role.id}`">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" :key="`checkbox_${role.id}`"
                          :checked="isRolesChecked(userRoles, role.id)" @click="
                            handleCheckboxClick(role.id, $event.target.checked)
                          " />{{ role.name }}
                      </label>
                    </div>
                    </div>             
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-all-add-edit py-2 px-5 btn-primary">
                    Change
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal change password -->
  <div class="row">
    <button ref="myModalPasswordBtn" type="button" class="btn btn-primary d-none" data-bs-toggle="modal"
      data-bs-target="#ModalPassword">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="ModalPassword" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
      aria-hidden="true">
      <div class="modal-dialog p-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="word_default p-4">
            <h3 class="text-center">Change Password</h3>
            <div class="row">
              <div class="col-md-12 d-flex flex-column align-items-center">
                <form @submit.prevent="updatePasswordUser" class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Enter description" class="form-control mt-1"
                          v-model="userPasswwordForm.email" required disabled />
                      </div>
                      <div class="form-group mt-2">
                        <label>Username</label>
                        <input type="text" placeholder="Enter description" class="form-control mt-1"
                          v-model="userPasswwordForm.name" required disabled />
                      </div>
                      <div class="form-group mt-2">
                        <label>Password</label>
                        <input type="password" placeholder="Enter description" class="form-control mt-1"
                          v-model="userPasswwordForm.password" required />
                      </div>
                      <div class="form-group mt-2">
                        <label>Repassword</label>
                        <input type="password" placeholder="Enter description" class="form-control mt-1"
                          v-model="userPasswwordForm.repassword" required />
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-all-add-edit py-2 px-5 btn-primary mt-4">
                      Change
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- add user -->
  <div class="row">
    <!-- Modal -->
    <div class="modal fade" id="ModalAddUser" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog p-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="word_default p-4">
            <h3 class="text-center">Create New User</h3>
            <div class="row">
              <div class="col-md-12 d-flex flex-column align-items-center">
                <form @submit.prevent="createNewUser" class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Enter description" class="form-control mt-1" v-model="newUser.email"
                          required />
                      </div>
                      <div class="form-group mt-2">
                        <label>Username</label>
                        <input type="text" placeholder="Enter description" class="form-control mt-1" v-model="newUser.name"
                          required />
                      </div>
                      <!-- <div class="form-group">
                      <label>Password</label>
                      <input type="password" placeholder="Enter password" class="form-control" v-model="newUser.password"
                        required />
                    </div> -->
                      <div class="form-group mt-2">
                        <label>Role</label>
                        <select class="form-select mt-1" aria-label="Default select example" v-model="newUser.role" required>
                          <option v-for="role in roles" :key="role.id" :value="`${role.id}`">
                            {{ role.name }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex">
                    <button type="submit" class="btn btn-all-add-edit py-2 px-3 btn-primary mt-3">
                      Add User
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<style lang="scss"></style>

<script>
import { exit } from "process";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import $ from "jquery";
import { createApp, h } from "vue";
// DataTable.use(DataTablesCore);
export default {
  data() {
    return {
      users: [],
      showUserForm: false, // biến đánh dấu hiển thị form thêm mới người dùng
      newUser: {
        // đối tượng người dùng mới
        name: "",
        email: "",
        role: "",
      },
      userForm: [],
      userPasswwordForm: [],
      userRoles: [],
      roles: [],
      dataTableData: [],
      showCheckbox: true,
    };
  },
  created() {
    this.axios.get("/api/user/roles").then((response) => {
      if (response.data.message === "success") {
        this.roles = response.data.data;
      }
    });
    this.fetchData();
  },
  methods: {
    // thêm mới người dùng
    addUser() {
      // thực hiện các xử lý để thêm mới người dùng vào danh sách
      // sau khi thêm mới xong, reset trạng thái của biến newUser và đóng form
      this.newUser = {
        name: "",
        email: "",
        role: "",
      };
      this.showUserForm = false;
    },
    createNewUser() {
      console.log(this.newUser);
      this.axios
        .post("/api/user/create", this.newUser)
        .then((response) => {
          if (response.data.status === 200 && response.data.success == true) {
            const newUser = response.data.data.user_created;
            if (newUser) {
              this.addRowData(newUser);
            }
            // this.$swal.fire({
            //   position: "top-end",
            //   icon: "success",
            //   title: `Add new user ${this.newUser.name} success`,
            //   showConfirmButton: false,
            //   timer: this.$config.notificationTimer ?? 1000,
            // });
            // this.newUser = {};
            alert(response.data.message);
          }
        })
        .catch((error) => {

          // this.$swal.fire({
          //   icon: "error",
          //   title: "Oops...",
          //   text: `Error ${error.response.status}: ${error.response.data.message}`,
          //   // footer: '<a href="">Why do I have this issue?</a>'
          // });
          alert(`Error ${error.response.status}: ${error.response.data.message}`);
        })
        .finally(() => (this.loading = false));
    },
    updateRolesUser() {
      console.log("check userForm:", this.userForm);
      this.axios
        .post(`/api/user/change-role-user/${this.userForm.id}`, this.userForm)
        .then((response) => {
          if (response.data.status === 200) {
            this.updateRowData(
              this.userForm.id,
              response.data.data.user_update
            );
            // this.$swal.fire({
            //   position: "top-end",
            //   icon: "success",
            //   title: `Change role ${this.userForm.name} Success`,
            //   showConfirmButton: false,
            //   timer: this.$config.notificationTimer ?? 1000,
            // });

            alert(response.data.message);
          }
        })
        .catch((error) => {
          // this.$swal.fire({
          //   icon: "error",
          //   title: "Oops...",
          //   text: `Error ${error.response.status}: ${error.response.data.message}`,
          // });
          alert(`Error ${error.response.status}: ${error.response.data.message}`);
        })
        .finally(() => (this.loading = false));
    },
    updatePasswordUser() {
      this.axios
        .post(
          `/api/user/change-password-user/${this.userPasswwordForm.id}`,
          this.userPasswwordForm
        )
        .then((response) => {
          if (response.data.status === 200) {
            alert(response.data.message);
            // this.$swal.fire({
            //   position: "top-end",
            //   icon: "success",
            //   title: `Change password ${this.userPasswwordForm.name} success`,
            //   showConfirmButton: false,
            //   timer: this.$config.notificationTimer ?? 1000,
            // });
            this.userPasswwordForm.password = null;
            this.userPasswwordForm.repassword = null;
            // if (response.data.success === true) {
            // }
          }
        })
        .catch((error) => {
          // this.$swal.fire({
          //   icon: "error",
          //   title: "Oops...",
          //   text: `Error ${error.response.status}: ${error.response.data.message}`,
          // });
          alert(`Error ${error.response.status}: ${error.response.data.message}`);
        })
        .finally(() => (this.loading = false));
    },
    setColumns() {
      const self = this;
      this.columns = [
        { data: "id", title: "ID" },
        { data: "name", title: "Name" },
        { data: "email", title: "Email" },

        {
          data: "id",
          title: "Roles",
          class: "columns-list",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return h(
                  "ul",
                  { class: "ul-list" },
                  rowData.roles.map((role) => {
                    return h("li", {}, [
                      h(
                        "p",
                        {
                          class: "",
                        },
                        role.name
                      ),
                    ]);
                  })
                );
              },
              data() {
                return {
                  rowData: rowData,
                };
              },
            });
            app.mount(cell);
          },
        },
        {
          data: "id",
          title: "Action",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return [
                  h(
                    "a",
                    {
                      to: `/admin/user-manager/change-role-user/${rowData.id}`,
                      class: "btn btn-all-add-edit me-2",
                      onClick: () => {
                        self.userForm = {
                          name: rowData.name,
                          email: rowData.email,
                          id: rowData.id,
                        };
                        self.showCheckbox = false;
                        setTimeout(() => {
                          self.showCheckbox = true;
                          self.userRoles = rowData.roles;
                          self.$refs.myModalBtn.click();
                        }, 10); // xử lý chờ 10 ms để userRoles kịp xóa list checkbox cũ
                      },
                    },
                    "Change Role"
                  ),
                  h(
                    "a",
                    {
                      to: `/admin/user-manager/change-pasword-user/${rowData.id}`,
                      class: "btn btn-all-add-edit",
                      onClick: () => {
                        self.showCheckbox = false;
                        self.userPasswwordForm = {
                          name: rowData.name,
                          email: rowData.email,
                          id: rowData.id,
                        };

                        self.$refs.myModalPasswordBtn.click();
                      },
                    },
                    "Change Password"
                  ),
                ];
              },
              data() {
                return {
                  rowData: rowData,
                };
              },
            });
            app.mount(cell);
          },
        },
      ];
    },
    fetchData() {
      this.axios
        .get("/api/allusers")
        .then((response) => {
          if (
            response.data.message === "success" &&
            response.data.status == 200
          ) {
            this.dataTableData = response.data.data.users;
            this.roles = response.data.data.roles;
            this.setColumns();
            this.table = $(this.$refs.myTable).DataTable({
              data: this.dataTableData,
              columns: this.columns,
              scrollX: true,
            });
          }
        })
        .catch((error) => {
          alert(`false`);
        });
    },
    isRolesChecked(roles, roleId) {
      // return true;
      if (Array.isArray(roles)) {
        const isCheck = roles.some((role) => role.id === roleId);
        this.userForm["role_" + roleId] = isCheck;
        return isCheck;
      } else {
        console.log("check isCheck: roleId", roleId, false);
        return false;
      }
      // return true;
    },
    handleCheckboxClick(roleId, checked) {
      this.userForm["role_" + roleId] = checked;
    },
    updateRowData(id, userUpdate) {
      let elementToUpdate = this.dataTableData.find((item) => item.id === id);
      if (elementToUpdate) {
        elementToUpdate.roles = userUpdate.roles;
      }

      $(this.$refs.myTable).DataTable().destroy();
      this.table = $(this.$refs.myTable).DataTable({
        data: this.dataTableData,
        columns: this.columns,
        scrollX: true,
      });
    },
    addRowData(userUpdate) {
      this.dataTableData.push(userUpdate);

      $(this.$refs.myTable).DataTable().destroy();
      this.table = $(this.$refs.myTable).DataTable({
        data: this.dataTableData,
        columns: this.columns,
        scrollX: true,
      });
    },
  },
};
</script>