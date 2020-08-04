<template>
  <div class="row">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Add Category</h3>
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
          <router-link :to="{ name: 'Categories' }">Categories</router-link>
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
    <vs-prompt class="add-task" :title="`Edit ${Category.label}`" :active.sync="editCate">
      <div class="row">
        <div class="col-12 edit1 mb-3">
          <div class="con-upload">
            <div class="con-img-upload">
              <div class="con-input-upload" v-if="!Category.image" style="margin: 5px !important;">
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

              <div class="img-upload" v-if="Category.image">
                <button type="button" @click="clear_file()" class="btn-x-file">
                  <i translate="translate" class="material-icons notranslate">clear</i>
                </button>
                <button class="btn-upload-file on-progress ready-progress" style="height: 100%;">
                  <i translate="translate" class="material-icons notranslate">cloud_done</i>
                  <span>100 %</span>
                </button>
                <img :src="Category.image" width="100%" />
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" label="Label*" v-model="Category.label" required />
        </div>

        <div class="col-lg-6 mb-3">
          <vs-input
            class="edit2_btns"
            label="Icon*"
            placeholder="eg-user"
            v-model="Category.icon"
            required
          />
          <a href="https://feathericons.com/" target="_blank">
            Explore icons
            <vs-icon icon="icon-external-link" icon-pack="feather" />
          </a>
        </div>

        <div class="col-lg-12 mb-3">
          <vs-textarea label="Description" v-model="Category.description" />
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
              <vs-dropdown-item @click="max_pagination = '5'">5</vs-dropdown-item>
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
            to="/add_category"
          >Add New</vs-button>
          <vs-button
            class="add_new ml-3"
            color="primary"
            @click="ChangeCategories(data.type)"
            v-if="oldData.length>0"
            type="filled"
            icon-pack="feather"
            icon="icon-chevron-left"
          >Back</vs-button>
        </template>
        <template slot="thead">
          <vs-th sort-key="No." class="table_no">No.</vs-th>
          <vs-th sort-key="image">Image</vs-th>
          <vs-th sort-key="product_no">Label</vs-th>
          <vs-th sort-key="title">Icon</vs-th>
          <vs-th sort-key="create_date">Description</vs-th>
          <vs-th sort-key="actions">Actions</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].id">{{ parseInt(indextr)+1}}</vs-td>
            <vs-td :data="data[indextr].image">
              <img class="product_image_table" :src="data[indextr].image" />
            </vs-td>
            <vs-td :data="data[indextr].label">{{ data[indextr].label }}</vs-td>

            <vs-td :data="data[indextr].icon">
              <vs-icon :icon="`icon-${data[indextr].icon}`" icon-pack="feather"></vs-icon>
            </vs-td>
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
                @click="EditCategory(data[indextr])"
              ></vs-button>
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="danger"
                icon-pack="feather"
                icon="icon-trash"
                type="flat"
                @click="deleteCat(data[indextr].id,index)"
              ></vs-button>
              <vs-button
                size="35px"
                radius
                class="p-1"
                color="primary"
                icon-pack="feather"
                icon="icon-chevron-right"
                type="flat"
                v-if="!data[indextr].category2_id"
                @click="filterCategories(data[indextr].id,data[indextr].category1_id)"
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
      oldData1: [],
      editCate: false,
      Category: {},
      Delete_type: "Product",
      delete_active: false,
      delete_id: [],
      total: "",
      max_pagination: "10",
      data_selected: [],
      data: [],
      current_id: null,
      oldData: [],
      category1: [],
      category2: [],
      category3: [],
      OldCategory: {},
      EditType: "",
    };
  },
  mounted() {
    this.getCategories();
  },
  watch: {},
  components: {},
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  methods: {
    deleteCat(id, index) {
      axios
        .post(`web/deleteCategory`, { id: id, type: this.data.type })
        .then((response) => {
          console.log(response.data);
          this.getCategories();
        })
        .catch((error) => {});
    },
    EditCategory(data) {
      console.log(" this.EditType: ", this.EditType);
      this.OldCategory = data;
      this.Category = data;
      this.editCate = true;
    },
    Cancel() {
      this.editCate = false;

      this.Category = this.OldCategory;
    },
    getCategories() {
      axios
        .get(`web/getCategories`)
        .then((response) => {
          var data = response.data;
          this.category1 = data.category1;
          this.data = this.category1;
          this.data.type = "category1";
          this.category2 = data.category2;
          this.category3 = data.category3;
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    filterCategories(id, category2) {
      if (category2) {
        this.oldData2 = this.data;
        this.data = this.category3.filter((data) => {
          return data.category2_id === id;
        });
        this.data.type = "category3";
      } else {
        this.oldData = this.data;
        this.current_id = id;
        this.data = this.category2.filter((data) => {
          return data.category1_id === id;
        });
        this.data.type = "category2";
      }
      console.log("this.data.type: ", this.data.type);
    },
    trigger() {
      this.$refs.fileInput.click();
    },
    clear_file() {
      this.Category.image = null;
    },
    onFileChange(e) {
      var file = e.target.files[0];
      this.Category.image = null;
      var reader = new FileReader();
      reader.onload = (e) => {
        this.Category.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    save() {
      this.editCate = false;
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-primary),0.2)",
        color: "primary",
        type: "border",
        scale: 0.4,
      });

      axios
        .post("web/editCategory", {
          data: this.Category,
          type: this.data.type,
        })
        .then((response) => {
          console.log("response: ", response);
          this.$vs.loading.close("#loading > .con-vs-loading");
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
          console.log("error: ", error);
          this.$vs.loading.close("#loading > .con-vs-loading");
        });
    },
    ChangeCategories(type) {
      if (type === "category3") {
        this.data = this.category2.filter((data) => {
          return data.category1_id === this.current_id;
        });
        this.data.type = "category2";
      }
      if (type === "category2") {
        this.data = this.category1;
        this.data.type = "category1";
        this.oldData = [];
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>