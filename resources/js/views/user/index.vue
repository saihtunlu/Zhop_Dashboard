<template>
  <div class="row" v-if="$gate.isUser_Read()">
    <!-- v-if="$gate.isAdmin()" -->

    <Delete
      :active="delete_active"
      :type="Delete_type"
      :delete_id="delete_id"
      @success="successDelete"
      @error="delete_active = false"
    />
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Employees</h3>
        <li class="BC_link">
          <router-link :to="{ name: 'Dashboard' }">
            <vs-icon icon="icon-home" icon-pack="feather" size="24px" color="primary" />
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
        <li class="vs-active BC_link">
          <a href="#" class="vs-breadcrumb--link">Users</a>
        </li>
      </ol>
    </nav>
    <!--End of breadcrumb -->

    <!-- Start of Table Content -->
    <div class="col-lg-12 padding div_shadow">
      <vs-table
        hoverFlat
        id="users_loading"
        class="vs-con-loading__container"
        multiple
        v-model="data_selected"
        pagination
        :max-items="max_pagination"
        search
        :data="data"
      >
        <template slot="header">
          <vs-dropdown vs-trigger-click>
            <vs-button
              class="pagenation"
              icon-after
              color="dark"
              type="border"
              icon-pack="feather"
              icon="icon-chevron-down"
            >1 - {{ max_pagination }} 0f {{ data_length}}</vs-button>
            <vs-dropdown-menu class="page_dropdown">
              <vs-dropdown-item @click="max_pagination = '10'">10</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '20'">20</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '30'">30</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '40'">40</vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
          <vs-button
            class="add_new"
            color="primary"
            type="filled"
            icon-pack="feather"
            icon="icon-user-plus"
            to="/add_user"
          >Add New</vs-button>
          <vs-dropdown vs-trigger-click class="action mr-2">
            <div class="a-icon">
              <span>Actions</span>
              <vs-icon icon-pack="feather" icon="icon-chevron-down"></vs-icon>
            </div>

            <vs-dropdown-menu class="action_dropdown">
              <vs-dropdown-item @click="deleteUsers()">
                <vs-icon icon-pack="feather" icon="icon-trash-2" />Move to trash
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="name">User Name</vs-th>
          <vs-th sort-key="email">Email</vs-th>
          <vs-th sort-key="role">Role</vs-th>
          <vs-th sort-key="Verified">Verified</vs-th>
          <vs-th sort-key="actions">View More</vs-th>
        </template>
        8
        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>

            <vs-td :data="data[indextr].name" class="profile_column">
              <div
                class="dot"
                style="background:rgb(var(--vs-success))"
                v-if="data[indextr].status == 'online'"
              ></div>
              <div
                class="dot"
                style="background:rgb(var(--vs-warning))"
                v-if="data[indextr].status == 'offline'"
              ></div>
              <vs-avatar size="38px" class="mr-3" :src="data[indextr].profile_image" />
              {{ data[indextr].name}}
            </vs-td>
            <vs-td :data="data[indextr].email">{{ data[indextr].email }}</vs-td>
            <vs-td :data="data[indextr].user_role.role.name">
              <vs-chip
                v-if="data[indextr].user_role.role.name == 'Administrator'"
                color="success"
              >{{ data[indextr].user_role.role.name }}</vs-chip>
              <vs-chip
                v-if="data[indextr].user_role.role.name == 'Shop Manager'"
                color="primary"
              >{{ data[indextr].user_role.role.name }}</vs-chip>
              <vs-chip
                v-if="data[indextr].user_role.role.name == 'Customer'"
                color="warning"
              >{{ data[indextr].user_role.role.name }}</vs-chip>
            </vs-td>
            <vs-td :data="data[indextr].email_verified_at">
              <vs-chip
                transparent
                closable
                icon-pack="feather"
                v-if="data[indextr].email_verified_at"
                color="primary"
                close-icon="icon-check"
              >Yes</vs-chip>
              <vs-chip
                transparent
                closable
                icon-pack="feather"
                v-if="!data[indextr].email_verified_at"
                color="warning"
                close-icon="icon-shield-off"
              >No</vs-chip>
            </vs-td>
            <vs-td :data="data[indextr]">
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                :to="{name: 'User', params: { data: data[indextr],id:data[indextr].id}}"
              ></vs-button>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </div>
  </div>
</template>
<script>
import Delete from "../../components/delete.vue";

export default {
  data() {
    return {
      Delete_type: "User",
      delete_active: false,
      delete_id: [],
      data: [],
      data_length: 0,
      users: [{}],
      max_pagination: "10",
      data_selected: [],
    };
  },
  mounted() {
    this.getUsers();
    this.listen();
  },
  components: {
    Delete,
  },
  watch: {},
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  methods: {
    deleteUsers() {
      this.delete_id = [];
      this.data_selected.forEach((data) => {
        this.delete_id.push(data.id);
      });
      this.delete_active = true;
    },
    listen() {
      Echo.join("App")
        .listen("UserOnline", (e) => {
          var id = e.user.id;
          var index = this.data
            .map((x) => {
              return x.id;
            })
            .indexOf(id);
          this.data[index].status = "online";
        })
        .listen("UserOffline", (e) => {
          var id = e.user.id;
          var index = this.data
            .map((x) => {
              return x.id;
            })
            .indexOf(id);
          this.data[index].status = "offline";
        });
    },
    getUsers() {
      if (this.$gate.isUser_Read()) {
        axios
          .get("/web/getUsers")
          .then((response) => {
            this.data = response.data;
            console.log("getUsers -> this.data", this.data);
            this.data_length = this.data.length;
          })
          .catch((error) => {});
      }
    },
    successDelete() {
      this.getUsers();
      this.delete_active = false;
    },
  },
};
</script>
<style></style>
