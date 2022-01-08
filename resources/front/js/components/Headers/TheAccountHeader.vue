<template>
  <base-header aria-label="Account header">
    <!-- Page title START -->
    <template #beforeProfile>
      <h1
        class="header__page-title"
        :class="{ 'skeleton-active': !isCameTranslation }"
      >
        {{ pageTitle }}
      </h1>
    </template>
    <!-- Page title END -->
  </base-header>
</template>

<script>
import { mapGetters } from "vuex";
import BaseHeader from "./BaseHeader";

export default {
  name: "TheAccountHeader",
  components: {
    BaseHeader
  },

  computed: {
    ...mapGetters({
      pageTitle: "account/pageTitle",
      isCameTranslation: "requestStatuses/isCameTranslation"
    })
  }
};
</script>
