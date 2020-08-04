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
        <p>Shipping Price : {{shippingPrice}}</p>
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
      cities: cities.sort(function (a, b) {
        return b.label - a.label || a.label.localeCompare(b.label);
      }),
      shippings: [],
      price: null,
      city: null,
      weight: null,
      shippingPrice: null,
    };
  },
  mounted() {
    this.getShipping();
  },
  methods: {
    getShipping() {
      axios
        .get(`web/getShippings`)
        .then((response) => {
          console.log(response.data);
          this.shippings = response.data;
        })
        .catch((error) => {});
    },
    calculate() {
      var getCity = {};
      this.shippings.forEach((data) => {
        var check = data.cities.filter((data) => {
          return data.value === this.city;
        });
        if (check.length !== 0) {
          getCity = data;
        }
      });
      var ShippingPrices = [];

      getCity.methods.forEach((data) => {
        if (data.isCondition) {
          if (data.by === "Price") {
            if (data.condition === "Greater") {
              if (parseInt(this.price) > parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }

            if (data.condition === "Greater or equal") {
              if (parseInt(this.price) >= parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Less than") {
              if (parseInt(this.price) < parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                    console.log("resultArray.price: ", resultArray.price);
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Less than or equal") {
              if (parseInt(this.price) <= parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Equal") {
              if (parseInt(this.price) === parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
          }
          if (data.by === "City") {
            if (data.condition === "Is") {
              if (this.city === data.with) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }

            if (data.condition === "Is not") {
              if (this.city !== data.with) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
          }

          if (data.by === "Weight") {
            if (data.condition === "Greater") {
              if (parseInt(this.weight) > parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }

            if (data.condition === "Greater or equal") {
              if (parseInt(this.weight) >= parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Less than") {
              if (parseInt(this.weight) < parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Less than or equal") {
              if (parseInt(this.weight) <= parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
            if (data.condition === "Equal") {
              if (parseInt(this.weight) === parseInt(data.with)) {
                var resultArray = {};
                if (data.type !== "Weight Based") {
                  resultArray.price = data.price;
                } else {
                  if (parseInt(this.weight) >= parseInt(data.initialWeight)) {
                    var price = data.initialPrice;
                    var check =
                      parseInt(this.weight) - parseInt(data.initialWeight);
                    if (check > 0) {
                      price = check * data.pricePerKg + parseInt(price);
                    }
                    resultArray.price = price;
                  }
                }
                if (resultArray.price) {
                  resultArray.method = data.type;
                  resultArray.condition = data.condition;
                  resultArray.by = data.by;
                  ShippingPrices.push(resultArray);
                }
              }
            }
          }
        }
      });
      console.log("ShippingPrices: ", ShippingPrices);

      this.shippingPrice = ShippingPrices.sort(
        (a, b) => parseInt(a.price) - parseInt(b.price)
      )[0].price;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>