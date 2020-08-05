<template>
  <div class="row vs-con-loading__container" id="loading">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">order</h3>
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
          <router-link :to="{ name: 'Shippings' }">Orders</router-link>
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
          <a class="vs-breadcrumb--link">{{order.order_id}}</a>
        </li>
      </ol>
    </nav>
    <!--End of breadcrumb -->

    <div class="col-lg-12 padding open div_shadow">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>
              {{order.order_id}}
            </h4>
            <vs-button
              class="add_new"
              color="primary"
              type="filled"
              icon-pack="feather"
              @click="update()"
            >Update</vs-button>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>

        <div class="col-lg-6">
          <h5
            class="header-text flex-align-center"
            style="margin-bottom:0.7rem !important;"
          >Order Detail</h5>
          <table class="personal_table employee_table">
            <tr>
              <td class="detail_p">Order ID</td>
              <td>{{ order.order_id }}</td>
            </tr>
            <tr>
              <td class="detail_p">Total Weight</td>
              <td>{{ order.totalWeight }} Kg</td>
            </tr>
            <tr>
              <td class="detail_p">Total Price</td>
              <td>${{ order.totalPrice }}</td>
            </tr>

            <tr>
              <td class="detail_p">Status</td>
              <td>
                <el-select
                  v-model="order.status"
                  filterable
                  class="invoice_el_input_sec"
                  allow-create
                  default-first-option
                >
                  <el-option label="Pending" value="Pending"></el-option>
                  <el-option label="Cancelled" value="Cancelled"></el-option>
                  <el-option label="Confirmed" value="Confirmed"></el-option>
                  <el-option label="Delivering" value="Delivering"></el-option>
                  <el-option label="Completed" value="Completed"></el-option>
                </el-select>
              </td>
            </tr>
            <tr>
              <td class="detail_p">Payment Method</td>
              <td>{{ order.payment_method }}</td>
            </tr>
            <tr v-if="order.payment_method ==='Bank Direct Transfer'">
              <td class="detail_p">Paid</td>
              <td>
                <el-select
                  v-model="order.paid"
                  filterable
                  class="invoice_el_input_sec"
                  allow-create
                  default-first-option
                >
                  <el-option label="No" :value="0"></el-option>
                  <el-option label="Yes" :value="1"></el-option>
                </el-select>
              </td>
            </tr>
          </table>
          <vs-divider color="rgb(var(--vs-gray2),0.5)" />
          <h5
            class="header-text flex-align-center"
            style="margin-bottom:0.7rem !important;"
          >Billing Address</h5>
          <table class="personal_table employee_table">
            <tr>
              <td class="detail_p">State</td>
              <td>{{ order.bill_address.state }}</td>
            </tr>
            <tr>
              <td class="detail_p">City</td>
              <td>{{ order.bill_address.city }}</td>
            </tr>
            <tr>
              <td class="detail_p">Address Line 1</td>
              <td>{{ order.bill_address.addressLine1 }}</td>
            </tr>
            <tr>
              <td class="detail_p">Address Line 2</td>
              <td>{{ order.bill_address.addressLine2 }}</td>
            </tr>
          </table>
        </div>

        <div class="col-lg-6">
          <h5
            class="header-text flex-align-center"
            style="margin-bottom:0.7rem !important;"
          >Customer Detail</h5>
          <table class="personal_table employee_table">
            <tr>
              <td class="detail_p">Name</td>
              <td>{{ order.userName }}</td>
            </tr>

            <tr>
              <td class="detail_p">Email</td>
              <td>{{ order.email }}</td>
            </tr>
            <tr>
              <td class="detail_p">Phone</td>
              <td>{{ order.phone }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-12 padding open div_shadow mt-base">
      <vs-table
        hoverFlat
        id="loading"
        class="vs-con-loading__container"
        pagination
        :max-items="max_pagination"
        search
        :data="items"
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
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="image">Product Image</vs-th>
          <vs-th sort-key="title">Title</vs-th>
          <vs-th sort-key="title">Quantity</vs-th>
          <vs-th sort-key="title">Subtotal</vs-th>
          <vs-th sort-key="create_date">Type</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].images">
              <img
                class="product_image_table"
                :src="data[indextr].type ==='Simple Product' ?data[indextr].images[0].path : data[indextr].attri1.image"
              />
            </vs-td>
            <vs-td :data="data[indextr].title">
              {{ data[indextr].type ==='Simple Product' ?data[indextr].title
              :
              data[indextr].product.title +' - '+data[indextr].attri1.name }}
              <span
                v-if="data[indextr].attri2"
              >{{'/' + data[indextr].attri2.name}}</span>
            </vs-td>
            <vs-td :data="data[indextr].quantity">
              <span>${{data[indextr].sale_price? data[indextr].sale_price:data[indextr].regular_price}}</span>
              x{{ data[indextr].quantity }}
            </vs-td>
            <vs-td :data="data[indextr].regular_price">
              <span>{{parseFloat(data[indextr].sale_price? data[indextr].sale_price:data[indextr].regular_price)* parseFloat(data[indextr].quantity)}}Ks</span>
            </vs-td>
            <vs-td
              :data="data[indextr].type"
            >{{ data[indextr].type ==='Simple Product' ? data[indextr].type :'Variable Product'}}</vs-td>
            <vs-td :data="data[indextr]">
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                :to="{name: 'Product', params: { id: data[indextr].type ==='Simple Product' ? data[indextr].id : data[indextr].product_id}}"
              ></vs-button>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </div>
  </div>
</template>
<script>
import { cities } from "../../components/address";
export default {
  data() {
    return {
      order: {},
      items: [],
      max_pagination: "10",
      total: 0,
    };
  },
  created() {
    var id = this.$route.params.id;
    this.getOrder(id);
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  mounted() {},
  methods: {
    getOrder(id) {
      axios
        .get(`web/getOrder/${id}`)
        .then((response) => {
          console.log("getOrder -> response", response);
          var data = null;
          data = response.data;
          this.order = data;
          var array = [];
          this.total = data.detail.length;
          data.detail.forEach((data) => {
            var product = {};
            if (data.product_type === "Simple Product") {
              product = data.product;
              product.quantity = data.quantity;
              array.push(product);
            } else {
              product = data.variation;
              product.quantity = data.quantity;
              array.push(product);
            }
          });
          this.items = array;
          console.log("getOrder -> this.items", this.items);
        })
        .catch((error) => {
          console.log("getOrder -> error", error);
        });
    },
    update() {
      axios
        .post(`web/updateOrder`, {
          id: this.order.id,
          status: this.order.status,
          paid: this.order.paid,
        })
        .then((response) => {
          this.$message({
            message:
              "Congratulation! You have successfully created an invoice.",
            type: "success",
          });
        })
        .catch((error) => {
          this.$message({
            message: "Error",
            type: "danger",
          });
        });
    },
  },
};
</script>
