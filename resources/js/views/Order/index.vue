<template>
  <div class="row">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Orders</h3>
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
        <li class="vs-active BC_link">
          <a class="vs-breadcrumb--link">Orders</a>
        </li>
      </ol>
    </nav>
    <!--End of breadcrumb -->
    <div class="col-lg-12 employee open padding div_shadow vs-con-loading__container" id="loading">
      <vs-table
        hoverFlat
        id="loading"
        class="vs-con-loading__container"
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
            >1 - {{ max_pagination }} 0f {{ data.length }}</vs-button>
            <vs-dropdown-menu class="page_dropdown">
              <vs-dropdown-item @click="max_pagination = '10'">10</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '20'">20</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '30'">30</vs-dropdown-item>
              <vs-dropdown-item @click="max_pagination = '40'">40</vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
          <!-- <vs-button
            class="add_new"
            color="primary"
            type="filled"
            icon-pack="feather"
            icon="icon-file-plus"
            @click="addPayment=true"
          >Add New</vs-button>-->
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="order_id">Order Id</vs-th>
          <vs-th sort-key="order_date">Order Date</vs-th>
          <vs-th sort-key="payment_method">Payment Method</vs-th>
          <vs-th sort-key="status">Status</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].order_id">{{ data[indextr].order_id }}</vs-td>
            <vs-td :data="data[indextr].created_at">
              <span
                class="truncate"
              >{{ $moment(data[indextr].created_at, "YYYY-MM-DDTHH:mm:ss.SSS").format('DD/MM/YYYY') }}</span>
            </vs-td>
            <vs-td :data="data[indextr].payment_method">
              <span class="truncate">{{ data[indextr].payment_method }}</span>
            </vs-td>
            <vs-td :data="data[indextr].status">
              <span class="truncate">{{ data[indextr].status }}</span>
            </vs-td>
            <vs-td :data="data[indextr]">
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="danger"
                icon-pack="feather"
                icon="icon-trash"
                type="flat"
                @click="deleteOrder(data[indextr].id,indextr)"
              ></vs-button>
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                :to="`/order/${data[indextr].id}`"
              ></vs-button>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      max_pagination: "10",
      data: [],
    };
  },
  mounted() {
    this.getOrders();
  },
  watch: {},
  components: {},
  created() {
    var index = this.$route.meta.index;
    this.listenForNewOrder();
    this.$emit("index", index);
  },
  methods: {
    listenForNewOrder() {
      Echo.channel("newOrder").listen("NewOrder", (data) => {
        console.log("listenForNewOrder -> data", data);
        this.getOrders();
      });
    },
    deleteOrder(id, index) {
      axios
        .delete(`web/deleteOrder/${id}`)
        .then((response) => {
          console.log(response.data);
          this.data.splice(index, 1);
        })
        .catch((error) => {});
    },
    getOrders() {
      axios
        .get(`web/getOrders`)
        .then((response) => {
          this.data = response.data;
          console.log("this.data: ", this.data);
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
  },
};
</script>
