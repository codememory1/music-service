<template>
  <div class="block-notifications-top">
    <h4 class="block-notifications-top__title">Notifications</h4>
    <loading-button
      class="bg--transparent color--accent block-notifications-top__read-all"
      aria-label="Mark all as read"
    >
      Mark all as read
    </loading-button>
  </div>
</template>

<script>
import LoadingButton from "../Buttons/LoadingButton";

export default {
  name: "NotificationsBlockTop",
  components: {
    LoadingButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/blocks/notifications-block-top";
</style>
