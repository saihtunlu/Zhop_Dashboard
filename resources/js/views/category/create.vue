<template>
    <div class="row vs-con-loading__container" id="loading">
        <!-- breadcrumb -->
        <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
            <ol class="vs-breadcrumb--ol">
                <h3 class="BC_header">Add Category</h3>
                <li class="BC_link">
                    <router-link :to="{ name: 'Dashboard' }">
                        <vs-icon
                            icon-pack="feather"
                            icon="icon-home"
                            size="small"
                            color="primary"
                        ></vs-icon>
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
                    <router-link :to="{ name: 'Categories' }"
                        >Categories</router-link
                    >
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
            <form-wizard
                @on-complete="save"
                shape="circle"
                color="rgba(var(--vs-primary),1)"
                error-color="rgb(var(--vs-danger))"
            >
                <tab-content
                    title="Main Parent Category"
                    icon="feather icon-user"
                    :before-change="validateFirstStep"
                >
                    <div class="con-tab-ejemplo">
                        <div class="row">
                            <vs-alert
                                title="Validate Error!"
                                :active.sync="first_error"
                                color="danger"
                                icon-pack="feather"
                                icon="icon-alert-circle"
                                closable
                                close-icon="icon-x"
                            >
                                <span
                                    >Please fill out all required fields!</span
                                >
                            </vs-alert>

                            <div
                                v-if="showAddNewCategory1"
                                class="col-12 edit1 mb-3"
                            >
                                <div class="con-upload">
                                    <div class="con-img-upload">
                                        <div
                                            class="con-input-upload"
                                            v-if="!Category.category1.image"
                                            style="margin: 5px !important;"
                                        >
                                            <input
                                                type="file"
                                                ref="fileInputCategory1"
                                                v-on:change="onFileChangeCat1"
                                            />
                                            <span class="text-input"
                                                >Upload File</span
                                            >
                                            <button
                                                type="button"
                                                @click="triggerCat1()"
                                                title="Upload"
                                                class="btn-upload-all vs-upload--button-upload"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_upload</i
                                                >
                                            </button>
                                        </div>

                                        <div
                                            class="img-upload"
                                            v-if="Category.category1.image"
                                        >
                                            <button
                                                type="button"
                                                @click="clear_fileCat1()"
                                                class="btn-x-file"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >clear</i
                                                >
                                            </button>
                                            <button
                                                class="btn-upload-file on-progress ready-progress"
                                                style="height: 100%;"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_done</i
                                                >
                                                <span>100 %</span>
                                            </button>
                                            <img
                                                :src="Category.category1.image"
                                                width="100%"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div
                                    style="animation:open 0.3s;"
                                    class="custom_input"
                                >
                                    <label
                                        for
                                        class="vs-input--label"
                                        style="display:block;"
                                        >Main Category*</label
                                    >
                                    <el-select
                                        v-model="Category.category1.label"
                                        collapse-tags
                                        filterable
                                        allow-create
                                        @change="checkCategory1"
                                        default-first-option
                                    >
                                        <el-option
                                            v-for="(data, n) in category1"
                                            :key="n"
                                            :label="data.label"
                                            :value="data.label"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div
                                v-if="showAddNewCategory1"
                                class="col-lg-12 mb-3"
                            >
                                <vs-input
                                    class="edit2_btns"
                                    label="Icon*"
                                    v-model="Category.category1.icon"
                                    required
                                />
                                <a href="https://boxicons.com/" target="_blank">
                                    Explore icons
                                    <vs-icon
                                        icon="icon-external-link"
                                        icon-pack="feather"
                                    />
                                </a>
                            </div>

                            <div
                                v-if="showAddNewCategory1"
                                class="col-lg-12 mb-3"
                            >
                                <vs-textarea
                                    label="Description"
                                    v-model="Category.category1.description"
                                />
                            </div>
                        </div>
                    </div>
                </tab-content>

                <tab-content
                    title="Main Sub Category"
                    icon="feather icon-user"
                    :before-change="validateSecStep"
                >
                    <div class="con-tab-ejemplo">
                        <div class="row">
                            <vs-alert
                                title="Validate Error!"
                                :active.sync="sec_error"
                                color="danger"
                                icon-pack="feather"
                                icon="icon-alert-circle"
                                closable
                                close-icon="icon-x"
                            >
                                <span
                                    >Please fill out all required fields!</span
                                >
                            </vs-alert>

                            <div
                                v-if="showAddNewCategory2"
                                class="col-12 edit1 mb-3"
                            >
                                <div class="con-upload">
                                    <div class="con-img-upload">
                                        <div
                                            class="con-input-upload"
                                            v-if="!Category.category2.image"
                                            style="margin: 5px !important;"
                                        >
                                            <input
                                                type="file"
                                                ref="fileInputCategory2"
                                                v-on:change="onFileChangeCat2"
                                            />
                                            <span class="text-input"
                                                >Upload File</span
                                            >
                                            <button
                                                type="button"
                                                @click="triggerCat2()"
                                                title="Upload"
                                                class="btn-upload-all vs-upload--button-upload"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_upload</i
                                                >
                                            </button>
                                        </div>

                                        <div
                                            class="img-upload"
                                            v-if="Category.category2.image"
                                        >
                                            <button
                                                type="button"
                                                @click="clear_fileCat2()"
                                                class="btn-x-file"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >clear</i
                                                >
                                            </button>
                                            <button
                                                class="btn-upload-file on-progress ready-progress"
                                                style="height: 100%;"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_done</i
                                                >
                                                <span>100 %</span>
                                            </button>
                                            <img
                                                :src="Category.category2.image"
                                                width="100%"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div
                                    style="animation:open 0.3s;"
                                    class="custom_input"
                                >
                                    <label
                                        for
                                        class="vs-input--label"
                                        style="display:block;"
                                        >Main Category*</label
                                    >
                                    <el-select
                                        v-model="Category.category2.label"
                                        collapse-tags
                                        filterable
                                        allow-create
                                        @change="checkCategory2"
                                        default-first-option
                                    >
                                        <el-option
                                            v-for="(data, n) in category2"
                                            :key="n"
                                            :label="data.label"
                                            :value="data.label"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div
                                v-if="showAddNewCategory2"
                                class="col-lg-12 mb-3"
                            >
                                <vs-input
                                    class="edit2_btns"
                                    label="Icon*"
                                    v-model="Category.category2.icon"
                                    required
                                />
                                <a href="https://boxicons.com/" target="_blank">
                                    Explore icons
                                    <vs-icon
                                        icon="icon-external-link"
                                        icon-pack="feather"
                                    />
                                </a>
                            </div>

                            <div
                                v-if="showAddNewCategory2"
                                class="col-lg-12 mb-3"
                            >
                                <vs-textarea
                                    label="Description"
                                    v-model="Category.category2.description"
                                />
                            </div>
                        </div>
                    </div>
                </tab-content>

                <tab-content
                    title="Category"
                    :before-change="validateThirdStep"
                    icon="feather icon-user"
                >
                    <div class="con-tab-ejemplo">
                        <div class="row">
                            <vs-alert
                                title="Validate Error!"
                                :active.sync="third_error"
                                color="danger"
                                icon-pack="feather"
                                icon="icon-alert-circle"
                                closable
                                close-icon="icon-x"
                            >
                                <span
                                    >Please fill out all required fields!</span
                                >
                            </vs-alert>

                            <div class="col-12 edit1 mb-3">
                                <div class="con-upload">
                                    <div class="con-img-upload">
                                        <div
                                            class="con-input-upload"
                                            v-if="!Category.image"
                                            style="margin: 5px !important;"
                                        >
                                            <input
                                                type="file"
                                                ref="fileInput"
                                                v-on:change="onFileChange"
                                            />
                                            <span class="text-input"
                                                >Upload File</span
                                            >
                                            <button
                                                type="button"
                                                @click="trigger()"
                                                title="Upload"
                                                class="btn-upload-all vs-upload--button-upload"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_upload</i
                                                >
                                            </button>
                                        </div>

                                        <div
                                            class="img-upload"
                                            v-if="Category.image"
                                        >
                                            <button
                                                type="button"
                                                @click="clear_file()"
                                                class="btn-x-file"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >clear</i
                                                >
                                            </button>
                                            <button
                                                class="btn-upload-file on-progress ready-progress"
                                                style="height: 100%;"
                                            >
                                                <i
                                                    translate="translate"
                                                    class="material-icons notranslate"
                                                    >cloud_done</i
                                                >
                                                <span>100 %</span>
                                            </button>
                                            <img
                                                :src="Category.image"
                                                width="100%"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <vs-input
                                    class="edit2_btns"
                                    label="Label*"
                                    v-model="Category.label"
                                    required
                                />
                            </div>

                            <div class="col-lg-6 mb-3">
                                <vs-input
                                    class="edit2_btns"
                                    label="Icon*"
                                    v-model="Category.icon"
                                    required
                                />
                                <a href="https://boxicons.com/" target="_blank">
                                    Explore icons
                                    <vs-icon
                                        icon="icon-external-link"
                                        icon-pack="feather"
                                    />
                                </a>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <vs-textarea
                                    label="Description"
                                    v-model="Category.description"
                                />
                            </div>
                        </div>
                    </div>
                </tab-content>
            </form-wizard>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        mobile: false
    },
    data() {
        return {
            first_error: false,
            sec_error: false,
            third_error: false,
            showAddNewCategory1: false,
            showAddNewCategory2: false,
            Category: {
                label: null,
                description: null,
                icon: null,
                image: null,
                category1: {
                    image: null
                },
                category2: {
                    image: null
                }
            },
            category1: [],
            PrimaryCategory2: [],
            category2: []
        };
    },
    created() {
        var index = this.$route.meta.index;
        this.$emit("index", index);
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        checkCategory1() {
            var check = null;
            check = this.category1.filter(data => {
                return data.label === this.Category.category1.label;
            });
            if (check.length === 0) {
                this.showAddNewCategory1 = true;
            } else {
                this.showAddNewCategory1 = false;
                this.Category.category1.image = null;
                this.Category.category1.icon = null;
                this.Category.category1.description = null;
            }
        },
        validateFirstStep() {
            if (this.showAddNewCategory1) {
                if (
                    !this.Category.category1.label ||
                    !this.Category.category1.image ||
                    !this.Category.category1.icon
                ) {
                    this.first_error = true;
                    return false;
                } else {
                    this.first_error = false;
                    this.category2 = [];
                    return true;
                }
            } else {
                if (!this.Category.category1.label) {
                    this.first_error = true;
                    return false;
                } else {
                    this.first_error = false;
                    var category1_id = this.category1.filter(data => {
                        return data.label === this.Category.category1.label;
                    })[0].id;
                    this.category2 = this.PrimaryCategory2.filter(data => {
                        return data.category1_id === category1_id;
                    });
                    return true;
                }
            }
        },
        triggerCat1() {
            this.$refs.fileInputCategory1.click();
        },
        clear_fileCat1() {
            this.Category.category1.image = null;
        },
        onFileChangeCat1(e) {
            var file = e.target.files[0];
            console.log("file: ", file);
            this.Category.category1.image = null;
            var reader = new FileReader();
            reader.onload = e => {
                this.Category.category1.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        checkCategory2() {
            var check = null;
            check = this.category2.filter(data => {
                return data.label === this.Category.category2.label;
            });
            if (check.length === 0) {
                this.showAddNewCategory2 = true;
            } else {
                this.showAddNewCategory2 = false;
                this.Category.category2.image = null;
                this.Category.category2.icon = null;
                this.Category.category2.description = null;
            }
        },
        validateSecStep() {
            if (this.showAddNewCategory2) {
                if (
                    !this.Category.category2.label ||
                    !this.Category.category2.image ||
                    !this.Category.category2.icon
                ) {
                    this.first_error = true;
                    return false;
                } else {
                    this.first_error = false;
                    return true;
                }
            } else {
                if (!this.Category.category2.label) {
                    this.first_error = true;
                    return false;
                } else {
                    this.first_error = false;
                    return true;
                }
            }
        },
        triggerCat2() {
            this.$refs.fileInputCategory2.click();
        },
        clear_fileCat2() {
            this.Category.category2.image = null;
        },
        onFileChangeCat2(e) {
            var file = e.target.files[0];
            this.Category.category2.image = null;
            var reader = new FileReader();
            reader.onload = e => {
                this.Category.category2.image = e.target.result;
            };
            reader.readAsDataURL(file);
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
            reader.onload = e => {
                this.Category.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        validateThirdStep() {
            if (
                !this.Category.image ||
                !this.Category.label ||
                !this.Category.icon
            ) {
                this.third_error = true;
                return false;
            } else {
                this.third_error = false;
                return true;
            }
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
                .post("web/addCategory", { data: this.Category })
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
                        message:
                            "Oops! There is an error while creating new invoice.",
                        type: "error"
                    });
                    console.log("error: ", error);
                    this.$vs.loading.close("#loading > .con-vs-loading");
                });
        },
        getCategories() {
            axios
                .get(`web/getCategories`)
                .then(response => {
                    var data = response.data;
                    this.category1 = data.category1;
                    this.PrimaryCategory2 = data.category2;

                    console.log(response.data);
                })
                .catch(error => {
                    console.log("error: ", error);
                });
        }
    }
};
</script>
