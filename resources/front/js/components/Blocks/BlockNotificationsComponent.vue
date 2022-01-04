<template>
  <div class="block-notifications">
    <div class="block-notifications-inner">
      <!-- Notification TOP START -->
      <div class="block-notifications-top">
        <h4 class="block-notifications__title">Notifications</h4>
        <loading-button
          class="bg--transparent color--accent block-notifications__read-all"
          aria-label="Mark all as read"
        >
          Mark all as read
        </loading-button>
      </div>
      <!-- Notification TOP END -->

      <!-- Content START -->
      <div class="block-notifications-content">
        <slot>
          <div class="no-notifications-wrapper">
            <svg-alias alias="empty-notifications" />
            <p>Notification list is empty</p>
          </div>
        </slot>
      </div>
      <!-- Content END -->
    </div>
  </div>
</template>
<script>
import LoadingButton from "../Buttons/LoadingButtonComponent";

export default {
  name: "BlockNotificationsComponent",
  components: {
    LoadingButton
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/blocks/notifications";
</style>
