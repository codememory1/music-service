<template>
  <base-navigation>
    <template v-slot:categories>
      <navigation-category>
        <template v-slot:items>
          <navigation-item
            :label="translation('generalSettings')"
            iconAlias="settings-svg"
            link="/general-settings"
          />
          <navigation-item
            :label="translation('security')"
            iconAlias="security-svg"
            link="/security"
          />
          <navigation-item
            :label="`${translation('language')} & ${translation('region')}`"
            class="language-region"
            iconAlias="language-svg"
            link="/languages"
          />
          <navigation-item
            :label="translation('notifications')"
            iconAlias="bell-svg"
            link="/notifications"
          />
          <navigation-item
            :label="translation('connectedApps')"
            iconAlias="connected-apps-svg"
            link="/connected-apps"
          />
        </template>
      </navigation-category>
    </template>
  </base-navigation>
</template>
<script>
import { mapGetters } from "vuex";
import BaseNavigation from "./BaseNavigationComponent";
import NavigationCategory from "./NavigationCategoryComponent";
import NavigationItem from "./NavigationItemComponent";

export default {
  name: "TheAccountNavigation",
  components: {
    BaseNavigation,
    NavigationCategory,
    NavigationItem
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation"
    })
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.language-region {
  & ::v-deep path {
    fill: none;
    stroke: $abs-light-bg-color;
  }

  &.active {
    & ::v-deep path {
      fill: none;
      stroke: $accent;
    }
  }
}
</style>
