<template>
  <div :class="'notification notification_type--' + type">
    <img-alias
      v-if="type === 'success'"
      alias="success-svg"
      alt="success"
      class="notification__icon"
    />
    <img-alias
      v-if="type === 'error'"
      alias="error-svg"
      alt="error"
      class="notification__icon"
    />
    <img-alias
      v-if="type === 'warning'"
      alias="warning-svg"
      alt="warning"
      class="notification__icon"
    />

    <div class="notification__content">
      <span class="notification__title">{{ title }}</span>
      <span class="notification__text">{{ message }}</span>
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseNotification",
  props: {
    /**
     * The type of notification.
     * Types {success, warning, error}
     *
     * @type {String}
     */
    type: {
      type: String,
      default: "success",
      required: false
    },

    /**
     * Name of notification
     *
     * @type {String}
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Notification message
     *
     * @type {String}
     */
    message: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/components/notification";
</style>
