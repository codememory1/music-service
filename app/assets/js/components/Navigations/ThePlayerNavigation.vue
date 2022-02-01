<template>
  <base-navigation aria-label="Player navigation">
    <template #categories>
      <base-navigation-category>
        <base-navigation-category-item
          alias-icon="home-svg"
          label="Home"
          :router-link="{ name: 'home' }"
        />
        <base-navigation-category-item
          alias-icon="search-svg"
          label="Search"
          :router-link="{ name: 'search' }"
        />
        <base-navigation-category-item
          alias-icon="history-svg"
          label="History"
          :router-link="{ name: 'history' }"
        />
      </base-navigation-category>
      <base-navigation-category>
        <base-navigation-category-item
          alias-icon="artist-svg"
          label="Artist"
          :router-link="{ name: 'artists' }"
        />
        <base-navigation-category-item
          alias-icon="album-svg"
          label="Album"
          :router-link="{ name: 'albums' }"
        />
        <base-navigation-category-item
          class="favorite-songs"
          alias-icon="like-svg"
          label="Favorite songs"
          :router-link="{ name: 'favorite-songs' }"
        />
        <base-navigation-category-item
          class="my-playlists"
          alias-icon="playlist-svg"
          label="My playlists"
          :router-link="{ name: 'playlists' }"
        />
      </base-navigation-category>
    </template>
  </base-navigation>
</template>

<script>
import BaseNavigation from "./BaseNavigation";
import BaseNavigationCategory from "./BaseNavigationCategory";
import BaseNavigationCategoryItem from "./BaseNavigationCategoryItem";

export default {
  name: "ThePlayerNavigation",
  components: {
    BaseNavigation,
    BaseNavigationCategory,
    BaseNavigationCategoryItem
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/player-navigation";
</style>
