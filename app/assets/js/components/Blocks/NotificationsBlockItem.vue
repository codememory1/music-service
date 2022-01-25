<template>
  <div class="notification">
    <img
      class="notification__user-photo"
      src="/public/images/user.png"
      :alt="userName"
    />

    <!-- Content START -->
    <div class="notification-content">
      <div class="notification-info">
        <span class="notification__user-name">{{ userName }}</span>
        <span class="notification__create-at">{{ createdAt }}</span>
      </div>
      <p class="notification__message">{{ message }}</p>
    </div>
    <!-- Content END -->
  </div>
</template>

<script>
export default {
  name: "NotificationsBlockItem",
  props: {
    /**
     * Sender name
     */
    userName: {
      type: String,
      required: true
    },

    /**
     * Sender user photo
     */
    userPhoto: {
      type: String,
      required: true
    },

    /**
     * Sender is online
     */
    isOnline: {
      type: Boolean,
      default: false
    },

    /**
     * Create date notification
     */
    createdAt: {
      type: String,
      required: true
    },

    /**
     * Message notification
     */
    message: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/blocks/notifications-block-item";
</style>
