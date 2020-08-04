<template>
  <div class="row">
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
        <h3 class="BC_header">Invoices</h3>
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
          <a href="#" class="vs-breadcrumb--link">Products</a>
        </li>
      </ol>
    </nav>
    <!--End of breadcrumb -->

    <div class="col-lg-12 employee open padding div_shadow">
      <vs-table
        hoverFlat
        id="loading"
        class="vs-con-loading__container"
        multiple
        v-model="data_selected"
        pagination
        :max-items="max_pagination"
        search
        :data="products"
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
            >1 - {{ max_pagination }} 0f {{ total }}</vs-button>
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
            icon="icon-plus"
            to="/add_product"
          >Add New</vs-button>
          <vs-dropdown vs-trigger-click class="action">
            <div class="a-icon">
              <span>Actions</span>
              <vs-icon icon-pack="feather" icon="icon-chevron-down"></vs-icon>
            </div>

            <vs-dropdown-menu class="action_dropdown">
              <vs-dropdown-item @click="deleteProducts()">
                <vs-icon icon-pack="feather" icon="icon-trash-2" />Move to trash
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="image">Product Image</vs-th>
          <vs-th sort-key="product_no">Product No</vs-th>
          <vs-th sort-key="title">Title</vs-th>
          <vs-th sort-key="create_date">Type</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].images">
              <img class="product_image_table" :src="data[indextr].images[0].path" />
            </vs-td>
            <vs-td :data="data[indextr].product_no">{{ data[indextr].product_no }}</vs-td>

            <vs-td :data="data[indextr].title">{{ data[indextr].title }}</vs-td>
            <vs-td :data="data[indextr].type">{{ data[indextr].type }}</vs-td>

            <vs-td :data="data[indextr]">
              <vs-button
                size="35px"
                radius
                class="p-1 mr-3"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                :to="{name: 'Product', params: { id: data[indextr].id}}"
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
      Delete_type: "Product",
      delete_active: false,
      delete_id: [],
      products: {},
      total: "",
      max_pagination: "10",
      data_selected: [],
    };
  },
  mounted() {
    this.getProducts();
  },
  watch: {},
  components: {
    Delete,
  },
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  methods: {
    deleteProducts() {
      this.delete_id = [];
      this.data_selected.forEach((data) => {
        this.delete_id.push(data.id);
      });
      this.delete_active = true;
    },
    successDelete() {
      this.getInvoices();
      this.delete_active = false;
    },
    getProducts() {
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-theme),0.4)",
        color: "primary",
        type: "border",
        scale: 0.6,
      });
      axios
        .get("/web/getProducts")
        .then((response) => {
          this.products = response.data;
          this.total = this.products.length;
          this.$vs.loading.close("#loading > .con-vs-loading");
        })
        .catch((error) => {
          const key = Object.keys(error.response.data.errors)[0];
          this.$vs.loading.close("#loading > .con-vs-loading");
        });
    },
  },
};
</script>
