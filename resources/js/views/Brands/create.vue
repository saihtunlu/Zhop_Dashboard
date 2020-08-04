<template>
  <div class="row vs-con-loading__container" id="loading">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Add Brand</h3>
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

    <div class="col-lg-12 padding open div_shadow">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Add New Brand
            </h4>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
        <div class="col-12 edit1 mb-3">
          <div class="con-upload">
            <div class="con-img-upload">
              <div class="con-input-upload" v-if="!brand.image" style="margin: 5px !important;">
                <input type="file" ref="fileInput" v-on:change="onFileChange" />
                <span class="text-input">Upload File</span>
                <button
                  type="button"
                  @click="trigger()"
                  title="Upload"
                  class="btn-upload-all vs-upload--button-upload"
                >
                  <i translate="translate" class="material-icons notranslate">cloud_upload</i>
                </button>
              </div>

              <div class="img-upload" v-if="brand.image">
                <button type="button" @click="clear_file()" class="btn-x-file">
                  <i translate="translate" class="material-icons notranslate">clear</i>
                </button>
                <button class="btn-upload-file on-progress ready-progress" style="height: 100%;">
                  <i translate="translate" class="material-icons notranslate">cloud_done</i>
                  <span>100 %</span>
                </button>
                <img :src="brand.image" width="100%" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <vs-input class="edit2_btns" label="Name*" v-model="brand.name" required />
        </div>
        <div class="col-lg-12 mb-3">
          <vs-textarea label="Description" v-model="brand.description" />
        </div>
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
  </div>
</template>

<script>
import YimoVueEditor from "../../components/yimo-vue-editor.js";

export default {
  props: {
    mobile: false
  },
  data() {
    return {
      brand: {
        name: "",
        description: "",
        image: null
      }
    };
  },
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  mounted() {},
  methods: {
    trigger() {
      this.$refs.fileInput.click();
    },
    clear_file() {
      this.brand.image = null;
    },
    onFileChange(e) {
      var file = e.target.files[0];
      this.brand.image = null;
      var reader = new FileReader();
      reader.onload = e => {
        this.brand.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    save() {
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-primary),0.2)",
        color: "primary",
        type: "border",
        scale: 0.4
      });

      axios
        .post("web/addBrand", { data: this.brand })
        .then(response => {
          console.log("response: ", response);
          this.$vs.loading.close("#loading > .con-vs-loading");
          this.$message({
            message:
              "Congratulation! You have successfully created an invoice.",
            type: "success"
          });
        })
        .catch(error => {
          this.$message({
            message: "Oops! There is an error while creating new invoice.",
            type: "error"
          });
          console.log("error: ", error);
          this.$vs.loading.close("#loading > .con-vs-loading");
        });
    }
  }
};
</script>
