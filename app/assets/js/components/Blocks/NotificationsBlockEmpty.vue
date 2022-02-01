<template>
  <div class="block-notifications-empty">
    <svg-alias alias="empty-notifications" />
    <p class="block-notifications-empty__text">Notification list is empty</p>
  </div>
</template>

<script>
export default {
  name: "NotificationsBlockEmpty"
};
</script>

<style lang="scss">
@import "../../../scss/components/blocks/notifications-block-empty";
</style>
