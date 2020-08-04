<template>
  <div class="row">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Brands</h3>
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
          <router-link :to="{ name: 'Brands' }">Brands</router-link>
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
          <a class="vs-breadcrumb--link">Add</a>
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
          <vs-button
            class="add_new"
            color="primary"
            type="filled"
            icon-pack="feather"
            icon="icon-file-plus"
            to="add_payment"
          >Add New</vs-button>
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="product_no">Type</vs-th>
          <vs-th sort-key="create_date">Description</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].type">{{ data[indextr].type }}</vs-td>

            <vs-td :data="data[indextr].description">
              <span class="truncate">{{ data[indextr].description }}</span>
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
                @click="deletePayment(data[indextr].id,indextr)"
              ></vs-button>
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                :to="`/payment/${data[indextr].id}`"
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
      editPayment: false,
      addPayment: false,
      max_pagination: "10",
      data: [],
      Payment: {
        banks: [],
      },
    };
  },
  mounted() {
    this.getPayments();
  },
  watch: {},
  components: {},
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  methods: {
    addBank() {
      this.Payment.banks.push({
        bankName: "",
        accNumber: "",
        holderName: "",
      });
    },
    deletePayment(id, index) {
      axios
        .delete(`web/deletePayment/${id}`)
        .then((response) => {
          console.log(response.data);
          this.data.splice(index, 1);
        })
        .catch((error) => {});
    },
    getPayments() {
      axios
        .get(`web/getPayments`)
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

<style lang="scss" scoped>
</style>