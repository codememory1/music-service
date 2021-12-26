<template>
  <base-navigation>
    <template v-slot:categories>
      <navigation-category>
        <template v-slot:items>
          <navigation-item
            label="General Settings"
            iconAlias="settings-svg"
            link="/general-settings"
          />
          <navigation-item
            label="Security & Login"
            iconAlias="security-svg"
            link="/security"
          />
          <navigation-item
            class="language-region"
            label="Language & Region"
            iconAlias="language-svg"
            link="/languages"
          />
          <navigation-item
            label="Notifications"
            iconAlias="bell-svg"
            link="/notifications"
          />
          <navigation-item
            label="Connected APPS"
            iconAlias="connected-apps-svg"
            link="/connected-apps"
          />
        </template>
      </navigation-category>
    </template>
  </base-navigation>
</template>
<script>
import BaseNavigation from "./BaseNavigationComponent";
import NavigationCategory from "./NavigationCategoryComponent";
import NavigationItem from "./NavigationItemComponent";

export default {
  name: "TheAccountNavigation",
  components: {
    BaseNavigation,
    NavigationCategory,
    NavigationItem
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
