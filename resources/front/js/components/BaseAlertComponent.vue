<template>
  <div class="alert" :class="{type}">
    <img-alias
      v-if="type === 'success'"
      alias="success-svg"
      alt="success"
      class="alert__icon"
    />
    <img-alias
      v-if="type === 'error'"
      alias="error-svg"
      alt="error"
      class="alert__icon"
    />
    <img-alias
      v-if="type === 'warning'"
      alias="warning-svg"
      alt="warning"
      class="alert__icon"
    />

    <div class="alert-content">
      <span class="alert__title">{{ title }}</span>
      <p class="alert__text">{{ message }}</p>
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseAlertComponent",
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
@import "../../scss/components/alert";
</style>
