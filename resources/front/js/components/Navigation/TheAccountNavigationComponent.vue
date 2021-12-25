<template>
  <base-navigation>
    <template v-slot:categories>
      <navigation-category>
        <template v-slot:items>
          <navigation-item label="Home" iconAlias="home-svg" link="/home" />
          <navigation-item
            label="General Settings"
            iconAlias="search-svg"
            link="/general-settings"
          />
          <navigation-item
            label="Security & Login"
            iconAlias="history-svg"
            link="/security"
          />
          <navigation-item
            label="Language & Region"
            iconAlias="history-svg"
            link="/language"
          />
          <navigation-item
            label="Notifications"
            iconAlias="history-svg"
            link="/notifications"
          />
          <navigation-item
            label="Connected APPS"
            iconAlias="history-svg"
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
