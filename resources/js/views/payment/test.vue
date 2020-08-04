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
          <vs-input class="edit2_btns" label="price*" v-model="price" required />
        </div>
        <div class="col-lg-12 mb-3">
          <vs-textarea label="weight" v-model="weight" />
        </div>

        <div class="col-lg-12 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">City*</label>
            <el-select v-model="city" filterable default-first-option>
              <el-option
                v-for="(city, n) in cities"
                :key="n"
                :label="city.label"
                :value="city.value"
              ></el-option>
            </el-select>
          </div>
        </div>
        <div class="col-12 flex-end">
          <vs-button
            color="primary"
            id="loading"
            class="add_user_btn vs-con-loading__container mr-3"
            @click="calculate()"
            type="filled"
          >Save</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { cities } from "../../components/address";
export default {
  data() {
    return {
      cities: cities.sort(function(a, b) {
        return b.label - a.label || a.label.localeCompare(b.label);
      }),
      payments: [],
      price: null,
      city: null,
      weight: null
    };
  },
  mounted() {
    this.getShipping();
  },
  methods: {
    getShipping() {
      axios
        .get(`web/getPayments`)
        .then(response => {
          console.log(response.data);
          this.payments = response.data;
        })
        .catch(error => {});
    },
    calculate() {
      var payments = [];
      this.payments.forEach(data => {
        if (data.restrictions) {
          var getResult = [];
          var restriction1 = data.restrictions[0];
          if (restriction1.by === "Cities") {
            if (restriction1.condition === "Is") {
              var check = restriction1.cities.filter(data => {
                return data.value === this.city;
              });
              if (check.length > 0) {
                var resultArray = {};
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                resultArray.type = data.type;
                getResult.push(resultArray);
              }
            }
            if (restriction1.condition === "Is not") {
              var check = restriction1.cities.filter(data => {
                return data.value !== this.city;
              });
              if (check.length > 0) {
                var resultArray = {};
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                resultArray.type = data.type;
                getResult.push(resultArray);
              }
            }
          }
          if (restriction1.by === "Shipping") {
            var cities = restriction1.shipping.cities;
            if (restriction1.condition === "Is") {
              var check = cities.filter(data => {
                return data.value === this.city;
              });
              if (check.length > 0) {
                var resultArray = {};
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                resultArray.type = data.type;
                getResult.push(resultArray);
              }
            }
            if (restriction1.condition === "Is not") {
              var check = cities.filter(data => {
                return data.value !== this.city;
              });
              if (check.length > 0) {
                var resultArray = {};
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                resultArray.type = data.type;
                getResult.push(resultArray);
              }
            }
          }
          if (restriction1.by === "Price") {
            if (restriction1.condition === "Greater") {
              if (parseInt(this.price) > parseInt(restriction1.price)) {
                var resultArray = {};
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                resultArray.type = data.type;
                getResult.push(resultArray);
              }
            }

            if (restriction1.condition === "Greater or equal") {
              if (parseInt(this.price) >= parseInt(restriction1.price)) {
                var resultArray = {};
                resultArray.type = data.type;
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                getResult.push(resultArray);
              }
            }
            if (restriction1.condition === "Less than") {
              if (parseInt(this.price) < parseInt(restriction1.price)) {
                var resultArray = {};
                resultArray.type = data.type;
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                getResult.push(resultArray);
              }
            }
            if (restriction1.condition === "Less than or equal") {
              if (parseInt(this.price) <= parseInt(restriction1.price)) {
                var resultArray = {};
                resultArray.type = data.type;
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                getResult.push(resultArray);
              }
            }
            if (restriction1.condition === "Equal") {
              if (parseInt(this.price) === parseInt(restriction1.price)) {
                var resultArray = {};
                resultArray.type = data.type;
                resultArray.price = restriction1.price;
                resultArray.condition = restriction1.condition;
                resultArray.by = restriction1.by;
                getResult.push(resultArray);
              }
            }
          }
          var getResult2 = [];
          if (data.restrictions[1]) {
            var restriction2 = data.restrictions[1];
            if (restriction2.by === "Cities") {
              if (restriction2.condition === "Is") {
                var check = restriction2.cities.filter(data => {
                  return data.value === this.city;
                });
                if (check.length > 0) {
                  var resultArray = {};
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  resultArray.type = data.type;
                  getResult2.push(resultArray);
                }
              }
              if (restriction2.condition === "Is not") {
                var check = restriction2.cities.filter(data => {
                  return data.value !== this.city;
                });
                if (check.length > 0) {
                  var resultArray = {};
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  resultArray.type = data.type;
                  getResult2.push(resultArray);
                }
              }
            }
            if (restriction2.by === "Shipping") {
              var cities = restriction2.shipping.cities;
              if (restriction2.condition === "Is") {
                var check = cities.filter(data => {
                  return data.value === this.city;
                });
                if (check.length > 0) {
                  var resultArray = {};
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  resultArray.type = data.type;
                  getResult2.push(resultArray);
                }
              }
              if (restriction2.condition === "Is not") {
                var check = cities.filter(data => {
                  return data.value !== this.city;
                });
                if (check.length > 0) {
                  var resultArray = {};
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  resultArray.type = data.type;
                  getResult2.push(resultArray);
                }
              }
            }
            if (restriction2.by === "Price") {
              if (restriction2.condition === "Greater") {
                if (parseInt(this.price) > parseInt(restriction2.price)) {
                  var resultArray = {};
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  resultArray.type = data.type;
                  getResult2.push(resultArray);
                }
              }

              if (restriction2.condition === "Greater or equal") {
                if (parseInt(this.price) >= parseInt(restriction2.price)) {
                  var resultArray = {};
                  resultArray.type = data.type;
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  getResult2.push(resultArray);
                }
              }
              if (restriction2.condition === "Less than") {
                if (parseInt(this.price) < parseInt(restriction2.price)) {
                  var resultArray = {};
                  resultArray.type = data.type;
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  getResult2.push(resultArray);
                }
              }
              if (restriction2.condition === "Less than or equal") {
                if (parseInt(this.price) <= parseInt(restriction2.price)) {
                  var resultArray = {};
                  resultArray.type = data.type;
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  getResult.push(resultArray);
                }
              }
              if (restriction2.condition === "Equal") {
                if (parseInt(this.price) === parseInt(restriction2.price)) {
                  var resultArray = {};
                  resultArray.type = data.type;
                  resultArray.price = restriction2.price;
                  resultArray.condition = restriction2.condition;
                  resultArray.by = restriction2.by;
                  getResult2.push(resultArray);
                }
              }
            }
            if (getResult.length > 0 && getResult2.length > 0) {
              payments.push(data);
            }
          } else {
            if (getResult.length > 0) {
              payments.push(data);
            }
          }
        } else {
          payments.push(data);
        }
      });
      console.log("payments: ", payments);
    }
  }
};
</script>

<style lang="scss" scoped>
</style>