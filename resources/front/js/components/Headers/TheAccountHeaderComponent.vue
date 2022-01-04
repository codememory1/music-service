<template>
  <base-header aria-label="Account header">
    <!-- Page title START -->
    <template v-slot:beforeProfile>
      <h1 class="header__page-title" :class="{ 'skeleton-active': isLoading }">
        {{ $store.getters["account/pageTitle"] }}
      </h1>
    </template>
    <!-- Page title END -->
  </base-header>
</template>
<script>
import { mapGetters } from "vuex";
import BaseHeader from "./BaseHeaderComponent";

export default {
  name: "TheAccountHeaderComponent",
  components: {
    BaseHeader
  },

  computed: {
    ...mapGetters({
      pageTitle: "account/pageTitle",
      isLoading: "loading/isLoading"
    })
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.header {
  &__page-title {
    font-size: 20px;
    color: $section-color;
    display: flex;
    align-items: center;

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 190px;
      height: 15px;
      border-radius: 10px;
      color: transparent;
    }
  }
}
</style>
