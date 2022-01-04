<template>
  <header class="header" role="banner">
    <!-- Slot to profile block -->
    <slot name="beforeProfile" />

    <!-- Profile START -->
    <div class="header-right-info">
      <div class="header-bell-wrapper" ref="bell">
        <base-button
          tabindex="-1"
          class="bg--transparent"
          :class="{ 'skeleton-active': isLoading }"
          @click="openBlockNotifications"
        >
          <svg-alias alias="bell-svg" />
        </base-button>

        <!-- Block with notifications -->
        <block-notifications :class="{ active: isOpenedBlockNotifications }" />
      </div>
      <div class="header-user" :class="{ 'skeleton-active': isLoading }">
        <img class="header-user__photo" src="/public/images/user.png" />
        <svg-alias alias="arrow-down-svg" />
      </div>
    </div>
    <!-- Profile END -->
  </header>
</template>
<script>
import { mapGetters } from "vuex";
import BaseButton from "../Buttons/BaseButtonComponent";
import BlockNotifications from "../../components/Blocks/BlockNotificationsComponent";
import ClickOut from "../../modules/ClickOut";

export default {
  name: "BaseHeaderComponent",

  components: {
    BaseButton,
    BlockNotifications
  },

  data: () => ({
    isOpenedBlockNotifications: false
  }),

  computed: {
    ...mapGetters({
      pageTitle: "account/pageTitle",
      isLoading: "loading/isLoading",
      user: "auth/getUserData"
    })
  },

  mounted() {
    ClickOut(this.$refs.bell, (status) => {
      if (status) {
        this.isOpenedBlockNotifications = false;
      }
    });
  },

  methods: {
    openBlockNotifications() {
      this.isOpenedBlockNotifications = !this.isOpenedBlockNotifications;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/header";
</style>
