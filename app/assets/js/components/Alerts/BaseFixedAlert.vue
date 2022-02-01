<template>
  <div role="alert" class="fixed-alert" :class="`type--${type}`">
    <!-- Img START -->
    <img-alias
      v-if="type === 'success'"
      alias="success-svg"
      alt="success"
      class="fixed-alert__icon"
    />
    <img-alias
      v-if="type === 'error'"
      alias="error-svg"
      alt="error"
      class="fixed-alert__icon"
    />
    <img-alias
      v-if="type === 'warning'"
      alias="warning-svg"
      alt="warning"
      class="fixed-alert__icon"
    />
    <!-- Img END -->

    <!-- Content START -->
    <div class="fixed-alert-content">
      <span class="fixed-alert__title">{{ title }}</span>
      <p class="fixed-alert__text">{{ message }}</p>
    </div>
    <!-- Content START -->
  </div>
</template>

<script>
export default {
  name: "BaseFixedAlert",
  props: {
    /**
     * The type of notification.
     * Types {success, warning, error}
     */
    type: {
      type: String,
      default: "success"
    },

    /**
     * Title of notification
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Notification message
     */
    message: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/alerts/base-fixed-alert";
</style>
