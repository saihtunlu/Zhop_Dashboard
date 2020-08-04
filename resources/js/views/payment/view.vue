<template>
  <div class="row vs-con-loading__container" id="loading">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Add Shipping</h3>
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
          <router-link :to="{ name: 'Shippings' }">Shippings</router-link>
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

    <div class="col-lg-12 padding open div_shadow">
      <div class="row">
        <div class="col-lg-12 pb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Type</label>
            <el-select v-model="Payment.type" filterable default-first-option>
              <el-option label="Cash On Delivery" value="Cash On Delivery"></el-option>
              <el-option label="Bank Direct Transfer" value="Bank Direct Transfer"></el-option>
            </el-select>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <vs-textarea label="Description" v-model="Payment.description" />
        </div>
        <div v-if="Payment.type ==='Bank Direct Transfer'" class="col-lg-12 mb-3">
          <div class="row">
            <div class="col-12">
              <div class="flex-between">
                <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
                  <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Banks
                </h4>

                <vs-button
                  class="add_new"
                  color="primary"
                  type="filled"
                  icon-pack="feather"
                  icon="icon-file-plus"
                  @click="addBank()"
                >Add New</vs-button>
              </div>
              <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
            </div>
            <div class="col-lg-12" v-for="(bank,n) in Payment.banks" :key="n">
              <vs-input class="edit2_btns" label="Bank Name" v-model="bank.bankName" required />
              <vs-input
                class="edit2_btns"
                label="Account Holder"
                v-model="bank.holderName"
                required
              />
              <vs-input
                class="edit2_btns"
                label="Account Number"
                v-model="bank.accNumber"
                required
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12 padding open div_shadow mt-base">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Restrictions
            </h4>
            <vs-button
              class="add_new"
              color="primary"
              type="filled"
              icon-pack="feather"
              icon="icon-file-plus"
              @click="addRestriction()"
            >Add New</vs-button>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
      </div>

      <el-collapse v-for="(restriction,n) in Payment.restrictions" :key="n" accordion>
        <el-collapse-item :name="n">
          <template slot="title">
            <vs-icon icon="icon-x" class="deleteAttr" @click="deleteMethod(n)" icon-pack="feather" />
          </template>

          <div class="row pb-3">
            <div class="col-lg-6 pb-3">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">By</label>
                <el-select v-model="restriction.by" filterable default-first-option>
                  <el-option label="Price" value="Price"></el-option>
                  <el-option label="Shipping" value="Shipping"></el-option>
                  <el-option label="Cities" value="Cities"></el-option>
                </el-select>
              </div>
            </div>

            <div class="col-lg-6 pb-3">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">Condition</label>
                <el-select v-model="restriction.condition" filterable default-first-option>
                  <el-option label="Equal" v-if="restriction.by=='Price'" value="Equal"></el-option>
                  <el-option
                    label="Is"
                    v-if="restriction.by==='Shipping' || restriction.by==='Cities'"
                    value="Is"
                  ></el-option>
                  <el-option
                    label="Is not"
                    v-if="restriction.by==='Shipping' || restriction.by==='Cities'"
                    value="Is not"
                  ></el-option>
                  <el-option label="Greater" v-if="restriction.by=='Price'" value="Greater"></el-option>
                  <el-option label="Less than" v-if="restriction.by=='Price'" value="Less than"></el-option>
                  <el-option
                    label="Greater or equal"
                    v-if="restriction.by=='Price'"
                    value="Greater or equal"
                  ></el-option>
                  <el-option
                    label="Less than or equal"
                    v-if="restriction.by=='Price'"
                    value="Less than or equal"
                  ></el-option>
                </el-select>
              </div>
            </div>

            <div class="col-lg-6 pb-3" v-if="restriction.by==='Cities'">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">With</label>
                <el-select v-model="restriction.newCities" multiple filterable default-first-option>
                  <el-option
                    v-for="(city, n) in cities"
                    :key="n"
                    :label="city.label"
                    :value="city.label"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-lg-6 pb-3" v-if="restriction.by==='Shipping'">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">Shipping</label>
                <el-select v-model="restriction.shipping_id" filterable default-first-option>
                  <el-option
                    v-for="(shipping, n) in shippings"
                    :key="n"
                    :label="shipping.title"
                    :value="shipping.id"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-lg-6 pb-3" v-if="restriction.by ==='Price' ">
              <vs-input
                class="edit2_btns"
                label="With - Price (Ks)"
                v-model="restriction.price"
                required
              />
            </div>
          </div>
        </el-collapse-item>
      </el-collapse>
      <div class="col-12 flex-end">
        <vs-button
          color="primary"
          id="loading"
          class="add_user_btn vs-con-loading__container mr-3"
          @click="save()"
          type="filled"
        >Save</vs-button>
      </div>
    </div>
  </div>
</template>
<script>
import { cities } from "../../components/address";
export default {
  data() {
    return {
      cities: cities.sort(function (a, b) {
        return b.label - a.label || a.label.localeCompare(b.label);
      }),
      Payment: {
        banks: [],
        restrictions: [{ newCities: [] }],
      },
      type: "",
    };
  },
  created() {
    var id = this.$route.params.id;
    this.getPayment(id);
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  mounted() {
    this.getShipping();
  },
  methods: {
    addRestriction() {
      if (this.Payment.restrictions.length > 1) {
        alert("Payment restrictions can be added two conditions.");
        return false;
      }
      var array = {};
      array.by = "";
      array.condition = "";
      array.with = "";
      array.price = 0;
      array.shipping_id = null;
      array.newCities = [];
      this.Payment.restrictions.push(array);
    },
    addBank() {
      this.Payment.banks.push({
        bankName: "",
        accNumber: "",
        holderName: "",
      });
    },
    getShipping() {
      axios
        .get(`web/getShippings`)
        .then((response) => {
          console.log(response.data);
          this.shippings = response.data;
        })
        .catch((error) => {});
    },
    getPayment(id) {
      axios
        .get(`web/getPayment/${id}`)
        .then((response) => {
          console.log("getPayment -> response", response);
          var data = null;
          data = response.data;
          this.Payment = data;
          var array = [];
          this.Payment.restrictions.forEach((data, index) => {
            if (data.by === "Cities") {
              data.cities.forEach((data2) => {
                array.push(data2.value);
              });
              this.Payment.restrictions[index].newCities = array;
              console.log(
                "getPayment -> this.Payment.restrictions[index]",
                this.Payment.restrictions[index]
              );
            }
          });
        })
        .catch((error) => {
          console.log("getPayment -> error", error);
        });
    },
    save() {
      axios
        .post("web/updatePayment", {
          data: this.Payment,
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
            message: "Oops! There is an error while creating new invoice.",
            type: "error",
          });
        });
    },
  },
};
</script>
