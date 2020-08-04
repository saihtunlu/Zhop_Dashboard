<template>
  <div id="parentx">
    <vs-sidebar
      id="Main_sidebar"
      :reduce="reduce"
      :reduce-not-hover-expand="notExpand"
      parent="body"
      :default-index="index"
      color="primary"
      class="sidebarx"
      spacer
      :click-not-close="true"
      v-model="active"
    >
      <div class="header_sidebar flex-between-center" style="width:100%;" slot="header">
        <div class="flex-align-center">
          <img class="logo-nav" style="width:40px;" :src="logo" alt />
          <span class="logo">{{title}}</span>
        </div>
        <span class="reduce_btn" v-if="mobile" @click="close_sidebar()">
          <vs-icon icon="icon-x" size="24px" icon-pack="feather" />
        </span>
        <span class="reduce_btn" v-if="!mobile " id="v-step-0" @click="reduce_sidebar()">
          <vs-icon
            :icon="reduce?'icon-chevrons-right':'icon-chevrons-left'"
            size="20px"
            icon-pack="feather"
          />
          <!-- <svg
            viewBox="0 0 24 24"
            width="20"
            height="20"
            stroke="currentColor"
            stroke-width="2"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="css-i6dzq1"
          >
            <circle cx="12" cy="12" r="10" />
            <circle v-if="reduce == false" cx="12" cy="12" r="3" />
          </svg>-->
        </span>
      </div>

      <vs-sidebar-item
        @click="close_sidebar()"
        index="1"
        to="/"
        icon-pack="feather"
        :class="{'vs-sidebar-item-active' : index===1 ,'vs-sidebar-item-deactive': index !== 1}"
        icon="icon-home"
      >Dashboard</vs-sidebar-item>
      <span class="custom_sidebar_divider">People</span>
      <vs-sidebar-item
        @click="close_sidebar()"
        index="2"
        to="/users"
        :class="{'vs-sidebar-item-active' : index===2 ,'vs-sidebar-item-deactive': index !== 2}"
        icon-pack="feather"
        icon="icon-user"
      >Users</vs-sidebar-item>
      <span class="custom_sidebar_divider">Commerce</span>
      <vs-sidebar-item
        @click="close_sidebar() "
        index="3"
        to="/products"
        :class="{'vs-sidebar-item-active' : index === 3 ,'vs-sidebar-item-deactive': index !== 3}"
        icon-pack="feather"
        icon="icon-shopping-bag"
      >Products</vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar() "
        index="4"
        to="/brands"
        :class="{'vs-sidebar-item-active' : index === 4 ,'vs-sidebar-item-deactive': index !== 4}"
        icon-pack="feather"
        icon="icon-check-circle"
      >Brands</vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar() "
        index="5"
        to="/categories"
        :class="{'vs-sidebar-item-active' : index === 5 ,'vs-sidebar-item-deactive': index !== 5}"
        icon-pack="feather"
        icon="icon-grid"
      >Categories</vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar() "
        index="6"
        to="/shippings"
        :class="{'vs-sidebar-item-active' : index === 6 ,'vs-sidebar-item-deactive': index !== 6}"
        icon-pack="feather"
        icon="icon-truck"
      >
        <span class="truncate">Shipping Methods</span>
      </vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar() "
        index="7"
        to="/payments"
        :class="{'vs-sidebar-item-active' : index === 7 ,'vs-sidebar-item-deactive': index !== 7}"
        icon-pack="feather"
        icon="icon-credit-card"
      >
        <span class="truncate">Payment Methods</span>
      </vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar() "
        index="8"
        to="/orders"
        :class="{'vs-sidebar-item-active' : index === 8 ,'vs-sidebar-item-deactive': index !== 8}"
        icon-pack="feather"
        icon="icon-gift"
      >
        Orders
        <vs-chip color="danger" v-if="newOrder!==0" class="sidebar_badge">{{newOrder}}</vs-chip>
      </vs-sidebar-item>

      <span class="custom_sidebar_divider">App</span>
      <vs-sidebar-item
        @click="close_sidebar() "
        index="9"
        to="/events"
        :class="{'vs-sidebar-item-active' : index === 9 ,'vs-sidebar-item-deactive': index !== 9}"
        icon-pack="feather"
        icon="icon-flag"
      >Events</vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar()"
        v-if="$gate.isInvoice_Read()"
        index="10"
        to="/invoices"
        :class="{'vs-sidebar-item-active' : index ===10 ,'vs-sidebar-item-deactive': index !== 10}"
        icon-pack="feather"
        icon="icon-file-text"
      >Invoices</vs-sidebar-item>

      <vs-sidebar-item
        @click="close_sidebar()"
        index="11"
        :class="{'vs-sidebar-item-active' : index === 11 ,'vs-sidebar-item-deactive': index !== 11}"
        icon="icon-mail"
        to="/mail"
        icon-pack="feather"
      >Mail</vs-sidebar-item>
      <vs-sidebar-item
        @click="close_sidebar()"
        index="12"
        :class="{'vs-sidebar-item-active' : index === 12 ,'vs-sidebar-item-deactive': index !== 12}"
        icon="icon-check-square"
        to="/todo"
        icon-pack="feather"
      >
        Todo
        <vs-chip color="warning" v-if="todo_noti!==0" class="sidebar_badge">{{todo_noti}}</vs-chip>
      </vs-sidebar-item>
      <vs-sidebar-item
        @click="close_sidebar()"
        index="13"
        :class="{'vs-sidebar-item-active' : index === 13 ,'vs-sidebar-item-deactive': index !== 13}"
        icon="icon-calendar"
        to="/calendar"
        icon-pack="feather"
      >
        Calendar
        <vs-chip color="primary" v-if="event" class="sidebar_badge">{{event}}</vs-chip>
      </vs-sidebar-item>
      <vs-sidebar-item
        @click="close_sidebar()"
        index="14"
        to="/settings"
        :class="{'vs-sidebar-item-active' : index === 14 ,'vs-sidebar-item-deactive': index !==14}"
        icon-pack="feather"
        icon="icon-settings"
      >Settings</vs-sidebar-item>
    </vs-sidebar>
  </div>
</template>
<script>
export default {
  props: {
    logo: "",
    newOrder: 0,
    event: null,
    todo_noti: 0,
    title: "",
    index: "",
    active: false,
    mobile: false,
  },
  data: () => ({
    notExpand: false,
    reduce: false,
  }),
  created() {
    if (this.mobile) {
      this.reduce = false;
    }
  },
  watch: {
    index: function (newVal, oldVal) {
      // watch it
    },
  },
  methods: {
    close_sidebar() {
      if (this.mobile) {
        this.$emit("close");
      }
    },
    reduce_sidebar() {
      this.reduce = !this.reduce;
      this.$emit("reduce");
    },
  },
};
</script>
<style></style>
