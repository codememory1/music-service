<template>
  <div v-if="isAuth" class="header-navbar-user-profile">
    <a :href="$env.PLAYER_URL">
      <img :src="authUserData.photo" :alt="authUserData.name" />
    </a>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "TheHomeHeaderUser",

  computed: {
    ...mapGetters({
      isAuth: "auth/isAuth",
      authUserData: "auth/getUserData"
    })
  }
};
</script>

<style lang="scss" scoped>
@import "../../../scss/components/headers/the-home-header-user";
</style>
