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
        <div class="col-lg-12 mb-3">
          <vs-input class="edit2_btns" label="Title*" v-model="shipping.title" required />
        </div>
        <div class="col-lg-12 mb-3">
          <vs-textarea label="Description" v-model="shipping.description" />
        </div>

        <div class="col-lg-12 mb-3">
          <div style="animation:open 0.3s;" class="custom_input multiShow">
            <label for class="vs-input--label" style="display:block;">Cities*</label>
            <el-select v-model="shipping.cities" multiple filterable default-first-option>
              <el-option
                v-for="(city, n) in cities"
                :key="n"
                :label="city.label"
                :value="city.label"
              ></el-option>
            </el-select>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12 padding open div_shadow mt-base">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4
              class="header-text flex-align-center display-sm-none"
              style="margin-bottom:0.7rem !important;"
            >
              <vs-icon
                size="small"
                class="custom_icon"
                icon-pack="feather"
                icon="icon-check-circle"
              ></vs-icon>Methods
            </h4>
            <div class="flex-align-center">
              <div
                style="animation:open 0.3s; margin-top:0px !important;"
                class="custom_input mt-0"
              >
                <el-select v-model="type" placeholder="Select type" filterable default-first-option>
                  <el-option v-for="type in types" :key="type" :label="type" :value="type"></el-option>
                </el-select>
              </div>
              <vs-button
                class="add_new"
                color="primary"
                type="filled"
                icon-pack="feather"
                icon="icon-file-plus"
                @click="addMethod()"
              >Add New</vs-button>
            </div>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
      </div>

      <el-collapse v-for="(method,n) in shipping.methods" :key="n" accordion>
        <el-collapse-item :name="n">
          <template slot="title">
            {{method.type}}
            <vs-icon icon="icon-x" class="deleteAttr" @click="deleteMethod(n)" icon-pack="feather" />
          </template>

          <div class="row pb-3">
            <div class="col-lg-6 pb-3 flex-y-end">
              <vs-input class="edit2_btns" label="Title*" v-model="method.label" required />
            </div>
            <div class="col-lg-6 pb-3 flex-y-end">
              <label class="mb-0 mr-2" for>Is Condition</label>
              <vs-switch v-model="method.isCondition" />
            </div>
            <div class="col-lg-6 pb-3 flex-y-end" v-if="method.type !== 'Weight Based'">
              <vs-input class="edit2_btns" label="Price*" v-model="method.price" required />
            </div>

            <div class="col-lg-6 pb-3 flex-y-end" v-if="method.type === 'Weight Based'">
              <vs-input
                class="edit2_btns"
                label="Initial Price*"
                v-model="method.initialPrice"
                required
              />
            </div>

            <div class="col-lg-6 pb-3 flex-y-end" v-if="method.type === 'Weight Based'">
              <vs-input
                class="edit2_btns"
                label="Initial Weight*"
                v-model="method.initialWeight"
                required
              />
            </div>

            <div class="col-lg-6 pb-3 flex-y-end" v-if="method.type === 'Weight Based'">
              <vs-input
                class="edit2_btns"
                label="Price Per Kg"
                v-model="method.pricePerKg"
                required
              />
            </div>

            <div class="col-lg-6 pb-3" v-if="method.isCondition">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">By</label>
                <el-select v-model="method.by" filterable default-first-option>
                  <el-option label="Price" value="Price"></el-option>
                  <el-option label="Weight" value="Weight"></el-option>
                  <el-option label="City" value="City"></el-option>
                </el-select>
              </div>
            </div>

            <div class="col-lg-6 pb-3" v-if="method.isCondition">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">Condition</label>
                <el-select v-model="method.condition" filterable default-first-option>
                  <el-option label="Equal" value="Equal"></el-option>
                  <el-option label="Is" value="Is"></el-option>
                  <el-option label="Is not" value="Is not"></el-option>
                  <el-option label="Greater" value="Greater"></el-option>
                  <el-option label="Less than" value="Less than"></el-option>
                  <el-option label="Greater or equal" value="Greater or equal"></el-option>
                  <el-option label="Less than or equal" value="Less than or equal"></el-option>
                </el-select>
              </div>
            </div>

            <div class="col-lg-6 pb-3" v-if="method.isCondition && method.by==='City'">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">With</label>
                <el-select v-model="method.with" filterable default-first-option>
                  <el-option
                    v-for="(city, n) in cities"
                    :key="n"
                    :label="city.label"
                    :value="city.value"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-lg-6 pb-3" v-if="method.isCondition && method.by ==='Price' ">
              <vs-input
                class="edit2_btns"
                label="With - Price (Ks)"
                v-model="method.with"
                required
              />
            </div>

            <div class="col-lg-6 pb-3" v-if="method.isCondition && method.by ==='Weight' ">
              <vs-input
                class="edit2_btns"
                label="With - Weight (Kg)"
                v-model="method.with"
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
      shipping: {
        methods: [],
        cities: [],
      },
      types: ["Free Shipping", "Flat Rate", "Weight Based"],
      type: "",
    };
  },
  mounted() {},
  methods: {
    addMethod() {
      var array = {};
      array.label = "";
      array.isCondition = false;
      array.by = "";
      array.condition = "";
      array.with = "";
      array.type = this.type;
      if (this.type !== "Weight Based") {
        array.price = 0;
      } else {
        array.initialPrice = 0;
        array.initialWeight = 0;
        array.pricePerKg = 0;
      }
      this.shipping.methods.push(array);
    },
    save() {
      axios
        .post(`web/createShipping`, { data: this.shipping })
        .then((response) => {
          this.$message({
            message:
              "Congratulation! You have successfully created an invoice.",
            type: "success",
          });
        })
        .catch((error) => {
          this.$message({
            message: "Error.",
            type: "error",
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>