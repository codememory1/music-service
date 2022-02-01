<template>
  <base-navigation aria-label="Account navigation">
    <template #categories>
      <base-navigation-category>
        <base-navigation-category-item
          alias-icon="settings-svg"
          :label="translation('generalSettings')"
          :router-link="{ name: 'general-settings' }"
        />
        <base-navigation-category-item
          alias-icon="security-svg"
          :label="translation('security')"
          :router-link="{ name: 'security' }"
        />
        <base-navigation-category-item
          class="languages"
          alias-icon="language-svg"
          :label="`${translation('language')} & ${translation('region')}`"
          :router-link="{ name: 'languages' }"
        />
        <base-navigation-category-item
          alias-icon="bell-svg"
          :label="translation('notifications')"
          :router-link="{ name: 'notifications' }"
        />
        <base-navigation-category-item
          alias-icon="connected-apps-svg"
          :label="translation('connectedApps')"
          :router-link="{ name: 'connected-apps' }"
        />
      </base-navigation-category>
    </template>
  </base-navigation>
</template>

<script>
import { mapGetters } from "vuex";
import BaseNavigation from "./BaseNavigation";
import BaseNavigationCategory from "./BaseNavigationCategory";
import BaseNavigationCategoryItem from "./BaseNavigationCategoryItem";

export default {
  name: "TheAccountNavigation",
  components: {
    BaseNavigation,
    BaseNavigationCategory,
    BaseNavigationCategoryItem
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation"
    })
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/account-navigation";
</style>
