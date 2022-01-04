<template>
  <div class="notification">
    <img
      class="notification__user-photo"
      src="/public/images/user.png"
      :alt="userName"
    />

	<!-- Content START -->
    <div class="notification-content">
      <div class="notification-content-top">
        <span class="notification__user-name">{{ userName }}</span>
        <span class="notification__create-at">{{ createdAt }}</span>
      </div>
      <div class="notification-content-down">
        <p class="notification__description">{{ description }}</p>
      </div>
    </div>
	<!-- Content END -->
  </div>
</template>
<script>
export default {
  name: "BaseNotificationComponent",
  props: {
    /**
     * @type {String}
     */
    userName: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    userPhoto: {
      type: String,
      required: true
    },

    /**
     * @type {Boolean}
     */
    isOnline: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * @type {String}
     */
    createdAt: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    description: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/components/notification";
</style>
