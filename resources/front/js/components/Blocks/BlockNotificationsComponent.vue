<template>
  <div class="block-notifications">
    <div class="block-notifications__wrapper">
      <div class="block-notifications__top">
        <h4 class="block-notifications__title">Notifications</h4>
        <span class="block-notifications__read-all" tabindex="-1"
          >Mark all as read</span
        >
      </div>
      <div class="block-notifications__content">
        <slot>
          <div class="no-notifications__wrapper">
            <svg-alias alias="empty-notifications" />
            <p>Notification list is empty</p>
          </div>
        </slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BlockNotifications"
};
</script>
<style lang="scss">
@import "../../../scss/components/blocks/blockNotifications";

.no-notifications__wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;

  & > p {
    color: $abs-light-bg-color;
    font-weight: 500;
    margin-top: 36px;
  }
}
</style>
