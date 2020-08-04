<template>
  <div class="row">
    <!-- popups -->
    <vs-prompt class="edit_model" title="Editing User Permission" :active.sync="general">
      <div class="row vs-con-loading__container" id="loading">
        <div class="col-lg-12 mt-base">
          <div class="permission_content">
            <div class="flex-between">
              <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
                <vs-icon size="small" icon-pack="feather" icon="icon-lock"></vs-icon>Permissions
              </h4>
            </div>
            <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
            <table class="permisson_table" cellspacing="10">
              <tr class="table_header">
                <td class="px-3 py-2">Module</td>
                <td class="px-3 py-2">Read</td>
                <td class="px-3 py-2">Update</td>
                <td class="px-3 py-2">Create</td>
                <td class="px-3 py-2">Delete</td>
              </tr>
              <tr
                class="table_content"
                v-for="(permission,index) in edit_permissions"
                v-bind:key="index"
              >
                <td class="px-3 py-2">{{permission.name}}</td>
                <td class="px-3 py-2">
                  <vs-checkbox class="checkbox_sign" v-model="permission.read"></vs-checkbox>
                </td>
                <td class="px-3 py-2">
                  <vs-checkbox class="checkbox_sign" v-model="permission.update"></vs-checkbox>
                </td>
                <td class="px-3 py-2">
                  <vs-checkbox class="checkbox_sign" v-model="permission.create"></vs-checkbox>
                </td>
                <td class="px-3 py-2">
                  <vs-checkbox class="checkbox_sign" v-model="permission.delete"></vs-checkbox>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-lg-12 flex-end">
          <vs-button color="primary" class="edit_btn" @click="saveGeneral()" type="filled">Save</vs-button>
          <vs-button color="warning" class="edit_btn" type="border" @click="cancel()">Cancel</vs-button>
        </div>
      </div>
    </vs-prompt>

    <Delete
      :active="delete_active"
      :type="Delete_type"
      :delete_id="delete_id"
      @success="successDelete"
      @error="delete_active = false"
      @cancel="delete_active=false"
    />
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">User</h3>
        <li class="BC_link">
          <router-link :to="{ name: 'Dashboard' }">
            <vs-icon icon-pack="feather" icon="icon-home" size="small" color="primary"></vs-icon>
          </router-link>
          <span
            translate="translate"
            aria-hidden="true"
            class="separator notranslate vs-breadcrum--separator"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-chevrons-right w-4 h-4"
            >
              <polyline points="13 17 18 12 13 7" />
              <polyline points="6 17 11 12 6 7" />
            </svg>
          </span>
        </li>
        <li class="BC_link">
          <router-link :to="{ name: 'Users' }">Users</router-link>
          <span
            translate="translate"
            aria-hidden="true"
            class="separator notranslate vs-breadcrum--separator"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-chevrons-right w-4 h-4"
            >
              <polyline points="13 17 18 12 13 7" />
              <polyline points="6 17 11 12 6 7" />
            </svg>
          </span>
        </li>
        <li class="vs-active BC_link">
          <a class="vs-breadcrumb--link">{{ User.name }}</a>
        </li>
      </ol>
    </nav>

    <!--End of breadcrumb -->

    <!-- Contents -->
    <div class="col-lg-12 padding mb-base div_shadow">
      <div class="row">
        <div class="col-lg-12 mb-2 flex-between">
          <h4 class="header-text pb-2">Account</h4>
        </div>
        <div class="col-lg-2 col-sm-12 profile_div">
          <el-image class="employee_profile_image" :src="User.profile_image">
            <div slot="placeholder" class="image-slot">
              <i class="el-icon-loading" style="font-size:18px !important; color:#fff;"></i>
            </div>
            <div slot="error" class="image-slot">
              <i class="feather icon-image"></i>
            </div>
          </el-image>
        </div>
        <div class="col-lg-5 col-md-12 table_div col-sm-12">
          <table class="employee_table">
            <tr>
              <td class="detail_p">User Name</td>
              <td>{{ User.name}}</td>
            </tr>
            <tr>
              <td class="detail_p">Email</td>
              <td>{{ User.email }}</td>
            </tr>
            <tr>
              <td class="detail_p">Role</td>
              <td>{{ User.user_role.role.name }}</td>
            </tr>
          </table>
        </div>
        <div class="col-lg-5 col-md-12 table_div col-sm-12">
          <table class="employee_table">
            <tr>
              <td class="detail_p">Verified</td>
              <td>
                <vs-chip
                  transparent
                  closable
                  icon-pack="feather"
                  v-if="User.email_verified_at"
                  color="success"
                  close-icon="icon-check"
                >Verified</vs-chip>
                <vs-chip
                  transparent
                  closable
                  icon-pack="feather"
                  v-if="!User.email_verified_at"
                  color="warning"
                  close-icon="icon-x"
                >No verified</vs-chip>
              </td>
            </tr>
            <tr>
              <td class="detail_p">Status</td>
              <td>
                <vs-chip
                  transparent
                  closable
                  icon-pack="feather"
                  v-if="User.status==='online'"
                  color="success"
                  close-icon="icon-wifi"
                >Online</vs-chip>
                <vs-chip
                  transparent
                  closable
                  icon-pack="feather"
                  v-if="User.status==='offline'"
                  color="warning"
                  close-icon="icon-wifi-off"
                >Offline</vs-chip>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-12 padding mb-base div_shadow">
      <div class="flex-between">
        <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
          <vs-icon size="small" class="custom_icon" icon-pack="feather" icon="icon-lock"></vs-icon>Permissions
        </h4>
        <vs-icon
          class="pointer icon_btns btn_primary"
          size="18px"
          icon-pack="feather"
          icon="icon-edit"
          @click="open_edit_general()"
        ></vs-icon>
      </div>
      <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
      <table class="permisson_table" cellspacing="10">
        <tr class="table_header">
          <td class="px-3 py-2">Module</td>
          <td class="px-3 py-2">Read</td>
          <td class="px-3 py-2">Update</td>
          <td class="px-3 py-2">Create</td>
          <td class="px-3 py-2">Delete</td>
        </tr>
        <tr class="table_content" v-for="(permission,index) in permissions" v-bind:key="index">
          <td class="px-3 py-2">{{permission.name}}</td>
          <td class="px-3 py-2">
            <vs-checkbox class="checkbox_sign" disabled v-model="permission.read"></vs-checkbox>
          </td>
          <td class="px-3 py-2">
            <vs-checkbox class="checkbox_sign" disabled v-model="permission.update"></vs-checkbox>
          </td>
          <td class="px-3 py-2">
            <vs-checkbox class="checkbox_sign" disabled v-model="permission.create"></vs-checkbox>
          </td>
          <td class="px-3 py-2">
            <vs-checkbox class="checkbox_sign" disabled v-model="permission.delete"></vs-checkbox>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import upload from "../../components/upload";
import Delete from "../../components/delete.vue";

export default {
  props: {
    mobile: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      general: false,
      Delete_type: "User",
      delete_active: false,
      delete_id: [],
      permissions: [],
      edit_permissions: [],
      editing: false,
      errorMessage: "",
      User: {},
    };
  },
  components: {
    Delete,
  },
  created() {
    var id = this.$route.params.id;
    var index = this.$route.meta.index;
    this.$emit("index", index);
    this.getUser(id);
  },
  mounted() {},
  methods: {
    cancel() {
      this.permissions = [];
      this.permissions.push(this.User.permission_user);
      this.permissions.push(this.User.permission_product);
      this.permissions.push(this.User.permission_invoice);
      this.general = false;
    },
    saveGeneral() {
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-theme),0.4)",
        color: "primary",
        type: "border",
        scale: 0.6,
      });
      axios
        .post(`web/updateUserPermission`, {
          user_id: this.User.id,
          permissions: this.edit_permissions,
        })
        .then((response) => {
          this.$message({
            message: "Successfully upaded!",
            type: "success",
          });
          this.$vs.loading.close("#loading > .con-vs-loading");
          this.general = false;
        })
        .catch((error) => {
          this.$vs.loading.close("#loading > .con-vs-loading");
          this.$message({
            message: "Oops! There is an error while updating.",
            type: "danger",
          });
        });
    },
    open_edit_general() {
      this.general = true;
      this.edit_permissions = this.permissions;
    },
    setDelete(id) {
      this.delete_id.push(id);
      this.delete_active = true;
    },
    getUser(id) {
      axios
        .get(`web/getUser/${id}`)
        .then((response) => {
          this.User = response.data;
          this.permissions.push(this.User.permission_user);
          this.permissions.push(this.User.permission_product);
          this.permissions.push(this.User.permission_invoice);
          console.log("getUser -> this.permissions", this.permissions);
        })
        .catch((error) => {
          console.log("getUser -> error", error);
        });
    },
    successDelete() {
      // this.delete_active = false;
      this.$router.push({ name: "Users" });
    },
  },
};
</script>

