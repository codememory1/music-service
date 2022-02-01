<template>
  <div class="header-bell" ref="bell">
    <base-button
      class="header-bell__button bg--transparent"
      @click="isOpen = !isOpen"
    >
      <svg-alias alias="bell-svg" />
    </base-button>

    <!-- Block with notifications -->
    <notifications-block :class="{ active: isOpen }" />
  </div>
</template>

<script>
import BaseButton from "../Buttons/BaseButton";
import NotificationsBlock from "../Blocks/NotificationsBlock";

export default {
  name: "BaseHeaderBell",
  components: {
    BaseButton,
    NotificationsBlock
  },

  data: () => ({
    isOpen: false
  })
};
</script>

<style lang="scss">
@import "../../../scss/components/headers/base-header-bell";
</style>
