<template>
  <div class="row" style="margin:0px -30px;">
    <div class="col-lg-3 col-6 mb-base col-md-3">
      <div class="summery classrooms">
        <div class="flex-between-center">
          <h5>Total Brands</h5>
        </div>
        <div class="flex" style="justify-content: space-between;align-items: flex-end;">
          <vs-icon class="icon_1 openicon" icon-pack="feather" icon="icon-star"></vs-icon>
          <p class="text-md mb-0">
            <animated-number :value="totalBrands" :formatValue="format" :duration="300" />
          </p>
          <vs-icon class="icon_2" color="primary" icon="bar_chart" />
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 col-md-3 mb-base">
      <div class="summery teachers">
        <div class="flex-between-center">
          <h5>Total Products</h5>
        </div>
        <div class="flex" style="justify-content: space-between;align-items: flex-end;">
          <vs-icon class="icon_1 openicon" icon-pack="feather" icon="icon-shopping-bag"></vs-icon>
          <p class="text-md mb-0">
            <animated-number :value="totalProducts" :formatValue="format" :duration="300" />
          </p>
          <vs-icon class="icon_2" color="danger" icon="bar_chart" />
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 col-md-3 mb-base">
      <div class="summery students">
        <div class="flex-between-center">
          <h5>Total Customer</h5>
        </div>
        <div class="flex" style="justify-content: space-between;align-items: flex-end;">
          <vs-icon class="icon_1 openicon" icon-pack="feather" icon="icon-users"></vs-icon>
          <p class="text-md mb-0">
            <animated-number :value="totalCustomer" :formatValue="format" :duration="300" />
          </p>
          <vs-icon class="icon_2" color="success" icon="bar_chart" />
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 col-md-3 mb-base">
      <div class="summery parents">
        <div class="flex-between-center">
          <h5>Orders Received</h5>
        </div>
        <div class="flex" style="justify-content: space-between;align-items: flex-end;">
          <vs-icon class="icon_1 openicon" icon-pack="feather" icon="icon-gift"></vs-icon>
          <p class="text-md mb-0">
            <animated-number :value="totalOrder" :formatValue="format" :duration="300" />
          </p>
          <vs-icon class="icon_2" color="warning" icon="bar_chart" />
        </div>
      </div>
    </div>

    <div class="col-lg-7 mb-base col-md-7">
      <div id="order_loading" class="padding div_shadow radius-1 vs-con-loading__container">
        <div class="flex-between-center">
          <h5>Incomes</h5>
          <el-date-picker
            @change="getOrder()"
            v-model="orderDate"
            class="chartDate"
            type="month"
            placeholder="Pick a month"
          ></el-date-picker>
        </div>
        <div id="Chart1" class="flex-align-center flex-center"></div>
        <div id="Chart2" class="flex-align-center flex-center"></div>
      </div>
    </div>
    <div class="col-lg-5 mb-base col-md-7">
      <div class="padding div_shadow">
        <div class="flex-between-center">
          <h5>Top Sell Products</h5>
        </div>
        <div style="min-height:408px; overflow-y:auto;overflow: visible !important;">
          <div
            v-if="sellProducts.length === 0"
            style="height: 100%;"
            class="flex-align-center flex-center"
          >
            <div class="flex-align-center flex-column">
              <img src="/storage/image/noEvent.png" style="width:120px;" alt />
              <p
                class="text-small text-center mt-3"
                style="color:rgb(var(--vs-dark),0.5)"
              >No Product</p>
            </div>
          </div>
          <div v-if="sellProducts.length !== 0">
            <router-link
              v-for="product in sellProducts"
              :key="product.id"
              :to="{name: 'Product', params: { id: product.id}}"
            >
              <div class="sellProduct flex mt-3" style="cursor: pointer;">
                <img
                  :src="product.images[0].path"
                  style="width: 65px !important;border-radius: 0.5rem;"
                  class="productImage-D mr-3"
                  alt
                />
                <div
                  style="
                  width: 90%;
                  display: flex;
                  flex-direction: column;
                  justify-content: space-between;"
                >
                  <div class="flex-between-center">
                    <p
                      class="text-md mb-1 truncate text-bold"
                      style="max-width: 60%;color:rgb(var(--vs-dark))"
                    >{{product.title}}</p>
                    <p
                      class="mb0 text-small truncate"
                      style="color:rgb(var(--vs-primary));text-align:right"
                      v-if="product.type==='Simple Product'"
                    >{{product.sale_price ? product.sale_price:product.regular_price}}Ks</p>
                    <p
                      class="mb0 text-small truncate"
                      style="color:rgb(var(--vs-primary));text-align:right"
                      v-else
                    >{{calculatePrice(product)}}</p>
                  </div>
                  <div class="flex-between-center mt-2">
                    <p
                      class="text-md mb-0"
                      style="max-width: 60%;color:rgb(var(--vs-dark))"
                    >By {{product.brand.name}}</p>
                    <vs-chip
                      closable
                      icon-pack="feather"
                      color="danger"
                      close-icon="icon-check"
                    >{{product.sold_out}} sold out!</vs-chip>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-7 mb-base col-md-7">
      <div class="padding div_shadow">
        <div class="flex-between-center">
          <h5>Today Events ({{new Date() | moment('DD/MM/YYYY')}} )</h5>
          <vs-dropdown vs-trigger-click class="contact_details">
            <vs-icon icon="more_horiz" />
            <vs-dropdown-menu class="nav_dropdown" id="chat_dropdown">
              <vs-dropdown-item class="nav_dropdown_item" to="/calendar">
                <vs-icon icon-pack="feather" icon="icon-eye" />View
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>
        <div style="height:308px; overflow-y:auto;">
          <div
            v-if="calendar.length === 0"
            style="height: 100%;"
            class="flex-align-center flex-center"
          >
            <div class="flex-align-center flex-column">
              <img src="/storage/image/noEvent.png" style="width:120px;" alt />
              <p
                class="text-small text-center mt-3"
                style="color:rgb(var(--vs-dark),0.5)"
              >No Calendar Event Today!</p>
            </div>
          </div>
          <div v-if="calendar.length !== 0">
            <div
              class="today_event flex-align-center mt-2"
              v-for="event in calendar"
              :key="event.id"
            >
              <vs-icon icon="icon-check" :color="event.cssClass" icon-pack="feather" class="mr-3" />
              <div class="event_details" style="max-width: 90%;">
                <p class="text-md mb-1 text-bold">{{event.title}}</p>
                <p class="mb0 text-small truncate">{{event.description}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 mb-base col-md-7">
      <div class="padding div_shadow">
        <FunctionalCalendar />
      </div>
    </div>
  </div>
</template>

<script>
import { FunctionalCalendar } from "vue-functional-calendar";
import AnimatedNumber from "animated-number-vue";

export default {
  props: {
    current_year_id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      Incomes: [],
      totalProducts: 0,
      totalBrands: 0,
      totalCustomer: 0,
      orderDate: new Date(),
      totalOrder: 0,
      days: [],
      numberOfOrder: [],
      sellProducts: [],
      invoice_year: 0,
      years: [],
      year_id: null,
      order_year: null,
      current_year: {},
      calendar: [],
    };
  },
  created() {
    var array = [];
    for (let i = 1; i <= 31; i++) {
      array.push(i);
    }
    this.days = array;
    this.getOrder();
    this.getCalendar();
    this.getCounter();
    this.getSellProduct();
  },
  mounted() {
    this.chart1();
    this.chart2();
  },
  components: {
    FunctionalCalendar,
    AnimatedNumber,
  },
  methods: {
    calculatePrice(product) {
      var prices = [];
      product.variations.forEach((data) => {
        prices.push(parseInt(data.regular_price));
      });
      var minVal = Math.min(...prices);
      var maxVal = Math.max(...prices);
      var priceRange =
        minVal === maxVal ? minVal + "Ks" : `${minVal}Ks - ${maxVal}Ks`;
      return priceRange;
    },
    format(value) {
      return value.toFixed(0);
    },
    chart1() {
      var options = {
        colors: ["#827AF3"],
        chart: {
          height: 340,
          type: "area",
          toolbar: {
            show: false,
          },
          zoom: {
            enabled: false,
          },
          animations: {
            enabled: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        series: [
          {
            name: "Incomes",
            data: this.Incomes,
          },
        ],
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0,
            stops: [0, 90, 100],
          },
        },
        xaxis: {
          categories: this.days,
        },
        yaxis: {
          title: {
            text: "Ks (Thousand)",
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " Ks (Thousand)";
            },
          },
        },
      };
      var chart = new ApexCharts(document.getElementById("Chart1"), options);
      chart.render();
      setTimeout(() => {
        this.$vs.loading.close("#order_loading > .con-vs-loading");
      }, 300);
    },
    chart2() {
      var options = {
        colors: ["#28C76F"],
        series: [
          {
            name: "Number Of Orders",
            data: this.numberOfOrder,
          },
        ],
        chart: {
          height: 205,
          type: "area",
          toolbar: {
            show: false,
          },
          zoom: {
            enabled: false,
          },

          animations: {
            enabled: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0,
            stops: [0, 90, 100],
          },
        },
        xaxis: {
          categories: this.days,
        },
        yaxis: {
          title: {
            text: "Number Of Orders",
          },
        },
      };
      var chart = new ApexCharts(document.getElementById("Chart2"), options);
      chart.render();
    },
    getOrder() {
      var year = this.$moment(this.orderDate).format("YYYY");
      var month = this.$moment(this.orderDate).format("MM");
      var date = [year, month];
      this.numberOfOrder = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      this.Incomes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      this.order_year = year;
      this.order_month = month;
      axios
        .post(`web/orderStatus/`, { date: date })
        .then((response) => {
          this.$vs.loading({
            background: "rgb(var(--vs-theme),0.2)",
            color: "primary",
            container: "#order_loading",
            type: "border",
            scale: 0.4,
          });
          document.getElementById("Chart1").innerHTML = "";
          document.getElementById("Chart2").innerHTML = "";

          var data = response.data;
          data.forEach((data) => {
            this.Incomes[parseInt(data.day) - 1] = parseInt(data.total) / 1000;
            this.numberOfOrder[parseInt(data.day) - 1] = data.count;
          });
          this.chart1();
          this.chart2();
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    getCalendar() {
      axios
        .get(`web/calendarDashboard`)
        .then((response) => {
          console.log(response.data);
          var data = response.data;
          const today = new Date();
          var tomorrow = new Date(today);
          tomorrow.setDate(tomorrow.getDate() - 1);
          tomorrow = this.$moment(tomorrow).format("YYYY-MM-DD HH:mm:ss");
          console.log("tomorrow: ", tomorrow);
          this.calendar = data.filter((data) => {
            var start = this.$moment(data.start).format("YYYY-MM-DD HH:mm:ss");
            var end = this.$moment(data.end).format("YYYY-MM-DD HH:mm:ss");

            return (
              this.$moment(today).isSameOrAfter(start) &&
              this.$moment(tomorrow).isSameOrBefore(end)
            );
            this.$emit("calendar_event", this.calendar.length);
          });

          this.$emit("calendarEvent", this.calendar.length);
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    getCounter() {
      axios
        .get(`web/getCounter/`)
        .then((response) => {
          var data = response.data;
          console.log("getCounter -> data", data);
          this.totalProducts = data.product;
          this.totalCustomer = data.customer;
          this.totalOrder = data.order;
          this.totalBrands = data.brand;
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    getSellProduct() {
      axios
        .get(`web/sellProduct/`)
        .then((response) => {
          // this.sellProducts = response.data;
          for (let i = 0; i < 6; i++) {
            this.sellProducts.push(response.data[0]);
          }
          console.log("getSellProduct -> this.sellProducts", this.sellProducts);
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