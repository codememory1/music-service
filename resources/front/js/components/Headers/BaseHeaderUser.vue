<template>
  <div class="header-user" :class="{ 'skeleton-active': !isCameAuthUserData }">
    <img
      class="header-user__photo"
      :src="authUserData.photo"
      :alt="authUserData.name"
    />
    <svg-alias alias="arrow-down-svg" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "BaseHeaderUser",

  computed: {
    ...mapGetters({
      authUserData: "auth/getUserData",
      isCameAuthUserData: "requestStatuses/isCameAuthUserData"
    })
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/headers/base-header-user";
</style>
