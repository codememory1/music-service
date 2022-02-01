<template>
  <div class="block-notifications">
    <div class="block-notifications-inner">
      <notifications-block-top />

      <!-- Content START -->
      <div class="block-notifications-content">
        <slot>
          <notifications-block-empty />
        </slot>
      </div>
      <!-- Content END -->
    </div>
  </div>
</template>

<script>
import NotificationsBlockTop from "./NotificationsBlockTop";
import NotificationsBlockEmpty from "./NotificationsBlockEmpty";

export default {
  name: "NotificationsBlock",
  components: {
    NotificationsBlockTop,
    NotificationsBlockEmpty
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/blocks/notifications-block";
</style>
