<template>
  <base-header aria-label="Player header">
    <!-- Search START -->
    <template v-slot:beforeProfile>
      <div
        class="player-header-search"
        role="search"
        aria-label="Search tracks"
      >
        <svg-alias alias="search-svg" />
        <input
          type="text"
          placeholder="Search"
          class="player-header-search__input"
        />
      </div>
    </template>
    <!-- Search END -->
  </base-header>
</template>
<script>
import BaseHeader from "./BaseHeaderComponent";

export default {
  name: "ThePlayerHeaderComponent",
  components: {
    BaseHeader
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/headers/player";
</style>
