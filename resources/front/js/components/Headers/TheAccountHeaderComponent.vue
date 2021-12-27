<template>
  <base-header>
    <template v-slot:beforeProfile>
      <h1 class="account-page__title">
        {{ $store.getters["account/pageTitle"] }}
      </h1>
    </template>
  </base-header>
</template>
<script>
import { mapGetters } from "vuex";
import BaseHeader from "./BaseHeaderComponent";

export default {
  name: "TheAccountHeader",
  components: {
    BaseHeader
  },

  computed: {
    ...mapGetters({
      pageTitle: "account/pageTitle"
    })
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.account-page {
  &__title {
    font-size: 20px;
    color: $section-color;
    display: flex;
    align-items: center;
  }
}
</style>
