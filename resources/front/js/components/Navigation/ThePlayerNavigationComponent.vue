<template>
  <base-navigation>
    <template v-slot:categories>
      <navigation-category>
        <template v-slot:items>
          <navigation-item label="Home" iconAlias="home-svg" link="/home" />
          <navigation-item
            label="Search"
            iconAlias="search-svg"
            link="/search"
          />
          <navigation-item
            label="History"
            iconAlias="history-svg"
            link="/history"
          />
        </template>
      </navigation-category>
      <navigation-category title="Your library">
        <template v-slot:items>
          <navigation-item
            label="Artist"
            iconAlias="artist-svg"
            link="/artists"
          />
          <navigation-item label="Album" iconAlias="album-svg" link="/albums" />
          <navigation-item
            label="Favorite songs"
            iconAlias="like-svg"
            link="/favorite-songs"
          />
          <navigation-item
            label="My playlists"
            iconAlias="playlist-svg"
            link="/playlists"
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
  name: "ThePlayerNavigation",
  components: {
    BaseNavigation,
    NavigationCategory,
    NavigationItem
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.navigation {
  border-right: 1px solid $light-bg;
}
</style>
