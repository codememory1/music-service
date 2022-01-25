<template>
  <base-header class="player-header" aria-label="Player header">
    <!-- Search START -->
    <template #beforeProfile>
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
import BaseHeader from "./BaseHeader";

export default {
  name: "ThePlayerHeader",
  components: {
    BaseHeader
  }
};
</script>

<style lang="scss" scoped>
@import "../../../scss/components/headers/player-header";
</style>
