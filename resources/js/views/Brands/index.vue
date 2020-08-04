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
    <vs-prompt class="add-event" :title="`Edit ${brand.name}`" :active.sync="editBrand">
      <div class="row">
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
          <vs-input class="edit2_btns" label="Label*" v-model="brand.name" required />
        </div>
        <!-- <div class="col-lg-6 mb-3">
          <vs-input
            class="edit2_btns"
            label="Icon*"
            placeholder="eg-user"
            v-model="brand.icon"
            required
          />
          <a href="https://feathericons.com/" target="_blank">
            Explore icons
            <vs-icon icon="icon-external-link" icon-pack="feather" />
          </a>
        </div>-->
        <div class="col-lg-12 mb-3">
          <vs-textarea label="Description" v-model="brand.description" />
        </div>
        <div class="col-lg-12 flex-end">
          <vs-button color="primary" class="edit_btn" @click="save()" type="filled">Save</vs-button>
          <vs-button color="warning" class="edit_btn" type="border" @click="Cancel()">Cancel</vs-button>
        </div>
      </div>
    </vs-prompt>
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
            to="/add_brand"
          >Add New</vs-button>
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="image">Image</vs-th>
          <vs-th sort-key="product_no">Name</vs-th>
          <vs-th sort-key="create_date">Description</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].image">
              <img class="product_image_table" :src="data[indextr].image" />
            </vs-td>
            <vs-td :data="data[indextr].name">{{ data[indextr].name }}</vs-td>

            <vs-td :data="data[indextr].description">
              <span class="truncate">{{ data[indextr].description }}</span>
            </vs-td>
            <vs-td :data="data[indextr]">
              <vs-button
                size="35px"
                radius
                class="p-1 mr-3"
                color="primary"
                icon-pack="feather"
                icon="icon-edit"
                type="flat"
                @click="EditBrand(data[indextr])"
              ></vs-button>
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="danger"
                icon-pack="feather"
                icon="icon-trash"
                type="flat"
                @click="deleteBrand(data[indextr].id,index)"
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
      editBrand: false,
      brand: {},
      max_pagination: "10",
      data: [],
      current_id: null,
      oldData: [],
      Brands: []
    };
  },
  mounted() {
    this.getBrands();
  },
  watch: {},
  components: {},
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  methods: {
    deleteBrand(id, index) {
      axios
        .delete(`web/deleteBrand/${id}`)
        .then(response => {
          console.log(response.data);
          this.data.splice(index, -1);
        })
        .catch(error => {});
    },
    EditBrand(data) {
      this.brand = data;
      this.editBrand = true;
    },
    Cancel() {
      this.editBrand = false;
    },
    getBrands() {
      axios
        .get(`web/getBrands`)
        .then(response => {
          this.data = response.data;
          console.log("this.data: ", this.data);
        })
        .catch(error => {
          console.log("error: ", error);
        });
    },

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
      this.editBrand = false;
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-primary),0.2)",
        color: "primary",
        type: "border",
        scale: 0.4
      });

      axios
        .post("web/editBrand", {
          data: this.brand
        })
        .then(response => {
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
          this.$vs.loading.close("#loading > .con-vs-loading");
        });
    }
  }
};
</script>

<style lang="scss" scoped>
</style>