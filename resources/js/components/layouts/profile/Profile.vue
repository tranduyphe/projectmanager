<template>
  <div class="profile">
    <div class="row">
      <div class="col-md-4">
        <div class="card show border border-0 profile-card-body">
          <div class="card-body p-0 card-body-user">
            <div class="row col-md-12 m-0 p-0 overflow-hidden background-avatar">
              <img src="/images/background-avatar.png" alt="" class="p-0 rounded-top">
            </div>
            <div class="avatar row col-md-12 m-0 p-0 d-flex justify-content-center position-absolute">
              <img src="/images/avatar.png" alt="">
              <input type="file" class="choose_avatar">
              <!-- <h6 class="text-center py-2">{{ authUser.name }}</h6> -->
            </div>
            <div class="description-profile">
              <div class="form-group px-5">
                <i class="fas fa-user text-secondary mx-3"></i>
                <router-link :to="{ name: 'Profile User' }" class="text-secondary">Profile</router-link>
              </div>
              <div class="form-group px-5 pb-3 mt-3">
                <i class="fas fa-lock text-secondary mx-3"></i>
                <router-link :to="{ name: 'Change Password' }" class="text-secondary">Change Password</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card show border border-0 profile-card-body">
          <div class="card-body ">
            <h4 class="card-title text-center fs-4">Change Profile</h4>
            <div class="col-md-12 mt-3">
              <form @submit.prevent="updateUser">
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label>UserName</label>
                      <input type="text" placeholder="username" class="form-control mt-1" disabled v-model="UserForm.name" />
                    </div>
                    <div class="form-group mt-2">
                      <label>FirstName</label>
                      <input type="text" placeholder="First Name" class="form-control mt-1" v-model="UserForm.first_name" />
                    </div>
                    <div class="form-group mt-2">
                      <label>Phone Number</label>
                      <input type="text" placeholder="Phone Number" class="form-control mt-1" v-model="UserForm.phone" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" placeholder="Email" class="form-control mt-1" disabled v-model="UserForm.email" />
                    </div>
                    <div class="form-group mt-2">
                      <label>LastName</label>
                      <input type="text" placeholder="Last Name" class="form-control mt-1" v-model="UserForm.last_name" />
                    </div>
                    <div class="form-group mt-2">
                      <label>Address</label>
                      <input type="text" placeholder="Address" class="form-control mt-1" v-model="UserForm.address" />
                    </div>
                  </div>
                </div>
                <div class="d-flex">
                  <button type="submit" class=" mt-4 btn-primary btn btn-all-add-edit py-2 px-4">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      // UserForm: {},
      languages: []
    }
  },
  computed: {
    authUser() {
      if (this.$store.getters.getAuthUser.id !== undefined) {
        return this.$store.getters.getAuthUser;
      }
      return JSON.parse(sessionStorage.getItem('authUser'));
    },
    UserForm() {
      return {
        name: this.authUser.name,
        email: this.authUser.email,
        first_name: this.authUser.first_name,
        last_name: this.authUser.last_name,
        phone: this.authUser.phone,
        address: this.authUser.address,
      }
    },
    ...mapGetters({
      loginResponse: "getLoginResponse",
    }),
  },
  methods: {
    ...mapActions(["storeUpdateUser"]),
    updateUser() {
      this.axios
        .post(`/api/project/update`, this.UserForm)
        .then((response) => {
          if (response.data.status === 200) {
            this.storeUpdateUser();
            // this.$swal.fire({
            //   position: 'top-end',
            //   icon: 'success',
            //   title: `Update Profile Success`,
            //   showConfirmButton: false,
            //   timer: this.$config.notificationTimer ?? 1000
            // })
            alert(response.data.message);
          }
        })
        .catch((error) => {
          this.$swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `Error ${error.response.status}: ${error.response.data.message}`,
          })
          // alert(`Error ${error.response.status}: ${error.response.data.message}`);
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>

<style></style>