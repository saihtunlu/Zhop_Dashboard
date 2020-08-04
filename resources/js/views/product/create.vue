<template>
  <div class="row vs-con-loading__container" id="loading">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Add Product</h3>
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
          <router-link :to="{ name: 'Products' }">Products</router-link>
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
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Add New Product
            </h4>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
        <div class="col-12 edit1 mb-3 productImage">
          <div class="con-upload">
            <div class="con-img-upload">
              <div class="con-input-upload" style="margin: 5px !important;">
                <input type="file" multiple="multiple" ref="fileInput" v-on:change="onFileChange" />
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

              <div class="img-upload" v-for="(image, n) in images" :key="n">
                <button type="button" @click="clear_file(n)" class="btn-x-file">
                  <i translate="translate" class="material-icons notranslate">clear</i>
                </button>
                <button class="btn-upload-file on-progress ready-progress" style="height: 100%;">
                  <i translate="translate" class="material-icons notranslate">cloud_done</i>
                  <span>100 %</span>
                </button>
                <img :src="image.url" width="100%" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <vs-input class="edit2_btns" label="Title*" v-model="product.title" required />
        </div>
        <div class="col-lg-12 mb-3">
          <vs-textarea label="Product Details" v-model="product.short_description" />
        </div>
        <div class="col-lg-12 mb-3">
          <label
            for
            class="vs-input--label"
            style="margin-bottom:2px !important;display:block;"
          >Additional Information</label>
          <yimo-vue-editor v-model="product.long_description" />
        </div>
        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" label="Video Url" v-model="product.video_link" required />
        </div>
        <div class="col-lg-6 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Product Type*</label>
            <el-select v-model="product.type" collapse-tags filterable default-first-option>
              <el-option v-for="(type, n) in types" :key="n" :label="type" :value="type"></el-option>
            </el-select>
          </div>
        </div>
        <div class="col-lg-6 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Categories*</label>
            <el-cascader
              :options="categories"
              v-model="product.categories"
              :props="{ multiple: true }"
              @change="changeCategory()"
              filterable
              collapse-tags
            ></el-cascader>
          </div>
        </div>
        <div class="col-lg-6 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Tags*</label>
            <el-select
              v-model="product.tags"
              collapse-tags
              filterable
              multiple
              allow-create
              default-first-option
            >
              <el-option v-for="(tag, n) in tags" :key="n" :label="tag.name" :value="tag.name"></el-option>
            </el-select>
          </div>
        </div>

        <div class="col-lg-6 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Brand*</label>
            <el-select v-model="product.brand_id" collapse-tags filterable>
              <el-option
                v-for="(brand, n) in brands"
                :key="n"
                :label="brand.name"
                :value="brand.id"
              ></el-option>
            </el-select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 padding open div_shadow mt-base" v-if="product.type==='Variable Product'">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Attribute
            </h4>
            <vs-button
              class="add_new"
              color="primary"
              type="filled"
              icon-pack="feather"
              icon="icon-file-plus"
              @click="addAttr()"
            >Add New</vs-button>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
      </div>

      <el-collapse v-for="(attribute,n) in attributes" :key="n" accordion>
        <el-collapse-item :name="n">
          <template slot="title">
            Attribute {{n+1}}
            <vs-icon icon="icon-x" class="deleteAttr" @click="deleteAttr(n)" icon-pack="feather" />
          </template>

          <div class="row pb-3">
            <div class="col-lg-6 pb-3 flex-y-end">
              <vs-input class="edit2_btns" label="Title*" v-model="attribute.title" required />
              <vs-button
                class="add_new"
                color="primary"
                type="filled"
                v-if="attribute.title"
                icon-pack="feather"
                style="min-width:150px;"
                icon="icon-file-plus"
                @click="addAttrDetail(n)"
              >Add {{attribute.title}}</vs-button>
            </div>
            <div class="col-lg-6 pb-3">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">Type*</label>
                <el-select v-model="attribute.type" filterable default-first-option>
                  <el-option label="Dropdown" value="Dropdown"></el-option>
                  <el-option label="List" value="List"></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-12 pb-3">
              <el-collapse v-for="(detail,detail_n) in attribute.details" :key="detail_n" accordion>
                <el-collapse-item :name="n">
                  <template slot="title">
                    {{attribute.title}} {{detail_n+1}}
                    <vs-icon
                      icon="icon-x"
                      class="deleteAttr"
                      @click="deleteAttrDetail(n,detail_n)"
                      icon-pack="feather"
                    />
                  </template>

                  <div class="row">
                    <div class="col-12 edit1 mb-3">
                      <div class="con-upload">
                        <div class="con-img-upload">
                          <div
                            class="con-input-upload"
                            v-if="!detail.image"
                            style="margin: 5px !important;"
                          >
                            <input type="file" ref="fileInputAttri" v-on:change="onFileChangeAttri" />
                            <!-- <span class="text-input">Upload File</span> -->
                            <button
                              type="button"
                              @click="triggerAttri(n,detail_n)"
                              title="Upload"
                              class="btn-upload-all vari_upload vs-upload--button-upload"
                            >
                              <i
                                translate="translate"
                                class="material-icons notranslate"
                              >cloud_upload</i>
                            </button>
                          </div>

                          <div class="img-upload" v-if="detail.image">
                            <button
                              type="button"
                              @click="clear_fileAttri(n,detail_n)"
                              class="btn-x-file"
                            >
                              <i translate="translate" class="material-icons notranslate">clear</i>
                            </button>
                            <button
                              class="btn-upload-file on-progress ready-progress"
                              style="height: 100%;"
                            >
                              <i translate="translate" class="material-icons notranslate">cloud_done</i>
                              <span>100 %</span>
                            </button>
                            <img :src="detail.image" width="100%" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <vs-input class="edit2_btns" label="Name*" v-model="detail.name" required />
                    </div>
                    <div class="col-lg-6 flex-y-end">
                      <vs-input class="edit2_btns" label="Color" v-model="detail.color" required />
                      <el-color-picker class="theme_color ml-3" v-model="detail.color"></el-color-picker>
                    </div>
                  </div>
                </el-collapse-item>
              </el-collapse>
            </div>

            <!-- <div class="col-lg-6 pb-3">
              <vs-checkbox
                style="justify-content: left;"
                v-if="product.type ==='Variable Product'"
                v-model="attribute.for_variation"
              >User For Variation</vs-checkbox>
            </div>-->
          </div>
        </el-collapse-item>
      </el-collapse>

      <div class="row">
        <div class="col-12 flex-end">
          <vs-button
            color="primary"
            id="loading"
            class="add_user_btn vs-con-loading__container mr-3"
            @click="saveAtt()"
            type="filled"
          >Save</vs-button>
        </div>
      </div>
    </div>
    <div class="col-lg-12 padding open div_shadow mt-base" v-if="product.type==='Simple Product'">
      <div class="row">
        <div class="col-lg-6 mb-3">
          <vs-input
            class="edit2_btns"
            type="number"
            label="Regular Price (Ks)"
            v-model="product.regular_price"
          />
        </div>
        <div class="col-lg-6 mb-3">
          <vs-input
            class="edit2_btns"
            type="number"
            label="Sale Price (Ks)"
            v-model="product.sale_price"
          />
        </div>

        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" type="number" label="Weight (kg)" v-model="product.weight" />
        </div>
        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" type="number" label="Width (cm)" v-model="product.width" />
        </div>
        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" type="number" label="Height (cm)" v-model="product.height" />
        </div>
        <div class="col-lg-6 mb-3">
          <vs-input class="edit2_btns" type="number" label="Length (cm)" v-model="product.Length" />
        </div>

        <div class="col-lg-6 mb-3">
          <div style="animation:open 0.3s;" class="custom_input">
            <label for class="vs-input--label" style="display:block;">Product Type*</label>
            <el-select v-model="product.stock" collapse-tags filterable default-first-option>
              <el-option v-for="(stock, n) in stocks" :key="n" :label="stock" :value="stock"></el-option>
            </el-select>
          </div>
        </div>
        <div class="col-lg-6 mb-3" v-if="product.stock ==='Manage Stock'">
          <vs-input
            class="edit2_btns"
            type="number"
            label="Number Of Stock"
            v-model="product.number_of_stock"
          />
        </div>
        <div class="col-lg-6 mb-3" v-if="product.stock ==='Manage Stock'">
          <vs-input
            class="edit2_btns"
            type="number"
            label="Threshold Stock"
            v-model="product.threshold"
          />
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
    <div class="col-lg-12 padding open div_shadow mt-base" v-if="show_variation">
      <div class="row">
        <div class="col-12">
          <div class="flex-between">
            <h4 class="header-text flex-align-center" style="margin-bottom:0.7rem !important;">
              <vs-icon size="small" class="custom_icon" icon="mood"></vs-icon>Variations
            </h4>
            <vs-button
              class="add_new"
              color="primary"
              type="filled"
              icon-pack="feather"
              icon="icon-file-plus"
              @click="addVariation()"
            >Add New</vs-button>
          </div>
          <vs-divider class="mt-0" color="rgb(var(--vs-gray2),0.5)" />
        </div>
      </div>

      <el-collapse v-for="(variation,n) in variations" :key="n" accordion>
        <el-collapse-item :name="n">
          <template slot="title">
            Variation {{n+1}}
            <vs-icon
              icon="icon-x"
              class="deleteAttr"
              @click="deleteVariation(n)"
              icon-pack="feather"
            />
          </template>

          <div class="row mb-3 pb-3">
            <div class="col-12 edit1 mb-3">
              <div class="con-upload">
                <div class="con-img-upload">
                  <div
                    class="con-input-upload"
                    v-if="!variation.file"
                    style="margin: 5px !important;"
                  >
                    <input type="file" ref="fileInputVari" v-on:change="onFileChangeVari" />
                    <!-- <span class="text-input">Upload File</span> -->
                    <button
                      type="button"
                      @click="triggerVari(n)"
                      title="Upload"
                      class="btn-upload-all vari_upload vs-upload--button-upload"
                    >
                      <i translate="translate" class="material-icons notranslate">cloud_upload</i>
                    </button>
                  </div>

                  <div class="img-upload" v-if="variation.file">
                    <button type="button" @click="clear_fileVari(n)" class="btn-x-file">
                      <i translate="translate" class="material-icons notranslate">clear</i>
                    </button>
                    <button
                      class="btn-upload-file on-progress ready-progress"
                      style="height: 100%;"
                    >
                      <i translate="translate" class="material-icons notranslate">cloud_done</i>
                      <span>100 %</span>
                    </button>
                    <img :src="variation.file" width="100%" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-3">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">{{detail1.name}}</label>
                <el-select v-model="variation.attribute1_id" filterable default-first-option>
                  <el-option
                    v-for="detail in detail1.details"
                    :key="detail.id"
                    :value="detail.id"
                    :label="detail.name"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-lg-6 mb-3" v-if="detail2.details.length !==0">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">{{detail2.name}}</label>
                <el-select v-model="variation.attribute2_id" filterable default-first-option>
                  <el-option
                    v-for="detail in detail2.details"
                    :key="detail.id"
                    :value="detail.id"
                    :label="detail.name"
                  ></el-option>
                </el-select>
              </div>
            </div>

            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Regular Price (Ks)"
                v-model="variation.regular_price"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Sale Price (Ks)"
                @change="cal(n)"
                v-model="variation.sale_price"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Weight (kg)"
                v-model="variation.weight"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Width (cm)"
                v-model="variation.width"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Height (cm)"
                v-model="variation.height"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Length (cm)"
                v-model="variation.Length"
              />
            </div>
            <div class="col-lg-6 mb-3">
              <div style="animation:open 0.3s;" class="custom_input">
                <label for class="vs-input--label" style="display:block;">Product Type*</label>
                <el-select v-model="variation.stock" collapse-tags filterable default-first-option>
                  <el-option v-for="(stock, n) in stocks" :key="n" :label="stock" :value="stock"></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-lg-6" v-if="variation.stock ==='Manage Stock'">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Number Of Stock"
                v-model="variation.number_of_stock"
              />
            </div>
            <div class="col-lg-6" v-if="variation.stock ==='Manage Stock'">
              <vs-input
                class="edit2_btns"
                type="number"
                label="Threshold Stock"
                v-model="variation.threshold"
              />
            </div>
          </div>
        </el-collapse-item>
      </el-collapse>

      <div class="row">
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
    mobile: false,
  },
  data() {
    return {
      value: [],

      vari_index: null,
      Attri_detail_index: null,
      Attri_index: null,
      show_variation: false,
      showAtt: false,
      stocks: ["In stock", "Out Of Stock", "Manage Stock"],
      types: ["Simple Product", "Variable Product"],
      product: {
        product_no: Math.floor(Math.random() * 90000), //for attribute
        regular_price: "",
        sale_price: "",
        discount: null,
        weight: null,
        width: null,
        height: null,
        stock: "",
        type: "",
        number_of_stock: null,
        threshold: null,
        title: "",
        short_description: "",
        long_description: "",
        video_link: "",
      },
      images: [],
      attributes: [
        {
          title: "",
          type: "",
          details: [],
          for_variation: false,
        },
      ],
      variations: [
        {
          attribute1_id: null,
          attribute2_id: null,
          regular_price: "",
          discount: null,
          sale_price: "",
          file: null,
          url: null,
          weight: null,
          width: null,
          Length: null,
          height: null,
          stock: "",
          number_of_stock: null,
          threshold: null,
        },
      ],
      detail1: {
        details: [],
      },
      detail2: {
        details: [],
      },
      categories: [],
      tags: [],
      price: "",
      category: "",
      success: "",
      new_category: "",
      brands: {},
    };
  },
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  mounted() {
    this.getCategories();
    this.getTags();
    this.getBrands();
  },
  components: {
    YimoVueEditor,
  },
  methods: {
    changeCategory() {
      console.log(this.product.categories);
    },
    deleteAttrDetail(n, detail_n) {
      this.attributes[n].details.splice(detail_n, 1);
    },
    addAttrDetail(n) {
      this.attributes[n].details.push({
        name: "",
        color: "",
        image: "",
      });
    },
    deleteAttr(n) {
      this.attributes.splice(n, 1);
    },
    deleteVariation(n) {
      this.variations.splice(n, 1);
    },
    cal(index) {
      this.variations[index].discount =
        100 -
        (parseInt(this.variations[index].sale_price) /
          parseInt(this.variations[index].regular_price)) *
          100;
    },
    addVariation() {
      var array = {
        attribute1_id: null,
        attribute2_id: null,
        regular_price: null,
        sale_price: null,
        weight: null,
        width: null,
        height: null,
        file: null,
        url: null,
        stock: "",
        discount: null,
        number_of_stock: null,
        threshold: null,
      };
      this.variations.push(array);
    },
    trigger() {
      this.$refs.fileInput.click();
    },
    triggerVari(n) {
      console.log("n: ", n);
      console.log("this.$refs.fileInputVari: ", this.$refs.fileInputVari);

      this.$refs.fileInputVari[0].click();
      this.vari_index = n;
    },
    clear_file(n) {
      console.log("n: ", n);
      this.images.splice(n, 1);
      console.log("this.images: ", this.images);
    },
    clear_fileVari(n) {
      console.log("n: ", n);
      this.variations[n].file = null;
      this.variations[n].url = null;
    },
    onFileChange(e) {
      if (parseInt(e.target.files.length) > 11) {
        alert("You can only upload a maximum of 10 files");
        return false;
      }
      this.images = [];
      var array = {};
      var files = e.target.files;
      files.forEach((data) => {
        array.file = data;
        array.url = URL.createObjectURL(data);
        this.images.push(array);
        array = {};
      });
    },
    onFileChangeVari(e) {
      var file = e.target.files[0];
      if (!/\.(gif|jpg|jpeg|png|bmp|GIF|JPG|PNG)$/.test(e.target.value)) {
        alert("The file uploaded need to be - gif,jpeg,jpg,png,bmp");
        return false;
      }
      var reader = new FileReader();
      reader.onload = (e) => {
        this.variations[this.vari_index].file = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    addAttr() {
      if (this.attributes.length > 1) {
        this.$message({
          message: "Only two attributes can be added currently.",
          type: "warning",
        });
        return false;
      }
      var array = {
        title: "",
        details: [
          {
            name: "",
            color: "",
            image: "",
          },
        ],
        type: "",
        for_variation: false,
      };
      this.attributes.push(array);
    },
    save() {
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-primary),0.2)",
        color: "primary",
        type: "border",
        scale: 0.4,
      });
      if (this.product.sale_price) {
        this.product.discount =
          100 -
          (parseInt(this.product.sale_price) /
            parseInt(this.product.regular_price)) *
            100;
      }
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      if (this.product.type === "Variable Product") {
        formData.append("variations", JSON.stringify(this.variations));
      }
      formData.append("product", JSON.stringify(this.product));

      if (this.images[0]) {
        formData.append("file1", this.images[0].file);
      }
      if (this.images[1]) {
        formData.append("file2", this.images[1].file);
      }
      if (this.images[2]) {
        formData.append("file3", this.images[2].file);
      }
      if (this.images[3]) {
        formData.append("file4", this.images[3].file);
      }
      if (this.images[4]) {
        formData.append("file5", this.images[4].file);
      }
      if (this.images[5]) {
        formData.append("file6", this.images[5].file);
      }
      if (this.images[6]) {
        formData.append("file7", this.images[6].file);
      }
      if (this.images[7]) {
        formData.append("file8", this.images[7].file);
      }
      if (this.images[8]) {
        formData.append("file9", this.images[8].file);
      }
      if (this.images[9]) {
        formData.append("file10", this.images[9].file);
      }
      if (this.images[10]) {
        formData.append("file11", this.images[10].file);
      }

      axios
        .post("web/addProduct", formData, config)
        .then((response) => {
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
    getCategories() {
      axios
        .get(`web/getProductCategories`)
        .then((response) => {
          this.categories = response.data;
        })
        .catch((error) => {});
    },
    getTags() {
      axios
        .get(`web/getTags`)
        .then((response) => {
          this.tags = response.data;
        })
        .catch((error) => {});
    },
    saveAtt() {
      this.$vs.loading({
        container: "#loading",
        background: "rgba(var(--vs-primary),0.2)",
        color: "primary",
        type: "border",
        scale: 0.4,
      });

      axios
        .post("web/addAttribute", {
          data: this.attributes,
          product_no: this.product.product_no,
        })
        .then((response) => {
          this.$vs.loading.close("#loading > .con-vs-loading");
          this.$message({
            message:
              "Congratulation! You have successfully created an invoice.",
            type: "success",
          });
          this.getVariation();
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
    getVariation() {
      axios
        .get(`web/getVariation/${this.product.product_no}`)
        .then((response) => {
          if (response.data[0]) {
            this.detail1 = response.data[0];
          }
          if (response.data[1]) {
            this.detail2 = response.data[1];
          }
          if (this.detail1) {
            this.show_variation = true;
          }
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    getBrands() {
      axios
        .get(`web/getBrands`)
        .then((response) => {
          this.brands = response.data;
          console.log("this.brands: ", this.brands);
        })
        .catch((error) => {
          console.log("error: ", error);
        });
    },
    triggerAttri(Attri_index, Attri_detail_index) {
      this.$refs.fileInputAttri[0].click();
      this.Attri_index = Attri_index;
      this.Attri_detail_index = Attri_detail_index;
    },
    clear_fileAttri(Attri_index, Attri_detail_index) {
      this.attributes[Attri_index].details[Attri_detail_index].image = null;
      this.attributes[Attri_index].details[Attri_detail_index].url = null;
    },
    onFileChangeAttri(e) {
      var file = e.target.files[0];
      if (!/\.(gif|jpg|jpeg|png|bmp|GIF|JPG|PNG)$/.test(e.target.value)) {
        alert("The file uploaded need to be - gif,jpeg,jpg,png,bmp");
        return false;
      }
      var reader = new FileReader();
      reader.onload = (e) => {
        this.attributes[this.Attri_index].details[
          this.Attri_detail_index
        ].image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
  },
};
</script>
