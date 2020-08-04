<template>
  <div class="row">
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="vs-breadcrumb vs-align-left">
      <ol class="vs-breadcrumb--ol">
        <h3 class="BC_header">Settings</h3>
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

        <li class="vs-active BC_link">
          <a class="vs-breadcrumb--link">Settings</a>
        </li>
      </ol>
    </nav>
    <!--End of breadcrumb -->

    <div class="col-lg-12 open">
      <vs-tabs position="left" id="setting_tabs" v-if="!mobile">
        <vs-tab
          label="Permissions"
          icon="icon-lock"
          class="div_shadow settings_content"
          icon-pack="feather"
        >
          <permission />
        </vs-tab>
        <vs-tab
          label="Invoice"
          icon="icon-file-text"
          class="settings_content div_shadow"
          icon-pack="feather"
        >
          <invoice />
        </vs-tab>

        <vs-tab
          label="Account"
          icon="icon-user"
          class="settings_content div_shadow"
          icon-pack="feather"
        >
          <myaccount :auth="{auth}" />
        </vs-tab>
        <vs-tab
          label="Theme"
          icon="icon-sun"
          class="settings_content div_shadow"
          icon-pack="feather"
        >
          <theme />
        </vs-tab>
        <vs-tab
          label="General"
          icon="icon-sliders"
          class="settings_content div_shadow"
          icon-pack="feather"
        >
          <general />
        </vs-tab>
      </vs-tabs>
      <div v-if="mobile">
        <div class="setting_lists" v-if="!see_content">
          <div
            class="flex-between-center setting_list"
            @click="see(setting.name)"
            v-for="(setting,n) in settings"
            :key="n"
          >
            <div class="list_text">
              <vs-icon
                :icon="setting.icon"
                class="mr-2 pointer custom_icon"
                size="16px"
                icon-pack="feather"
              />
              {{setting.name}}
            </div>
            <vs-icon icon="icon-chevron-right" color="rgb(var(--vs-dark),0.5)" icon-pack="feather" />
          </div>
        </div>
        <div v-if="see_content">
          <div class="back_to_lists">
            <vs-icon
              icon="icon-chevron-left"
              @click="returnToList()"
              class="mx-2 custom_icon"
              icon-pack="feather"
            />
            {{setting_name}}
          </div>

          <div class="setting_contents">
            <slide-y-down-transition>
              <permission v-if="setting_name==='Permissions'" />
              <invoice v-if="setting_name==='Invoice'" />
              <myaccount :auth="{auth}" v-if="setting_name==='My Account'" />
              <theme v-if="setting_name ==='Theme'" />
              <general v-if="setting_name ==='General'" />
            </slide-y-down-transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import permission from "./permissions.vue";
import invoice from "./invoice.vue";
import myaccount from "./my_account.vue";
import theme from "./theme.vue";
import general from "./General.vue";

export default {
  props: {
    current_year_id: null,
    mobile: false,
    auth: {}
  },
  data() {
    return {
      setting_name: "",
      see_content: false,
      settings: [
        {
          icon: "icon-lock",
          name: "Permissions"
        },
        {
          icon: "icon-file-text",
          name: "Invoice"
        },
        {
          icon: "icon-sliders",
          name: "General"
        },
        {
          icon: "icon-sun",
          name: "Theme"
        },
        {
          icon: "icon-user",
          name: "My Account"
        }
      ]
    };
  },
  created() {
    var index = this.$route.meta.index;
    this.$emit("index", index);
  },
  components: {
    permission,
    invoice,
    myaccount,
    theme,
    general
  },
  mounted() {},
  methods: {
    see(data) {
      this.see_content = true;
      this.setting_name = data;
    },
    returnToList() {
      this.see_content = false;
      this.setting_name = "";
    }
  }
};
</script>

