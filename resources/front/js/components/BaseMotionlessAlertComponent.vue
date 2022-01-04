<template>
  <div
    v-if="type === 'success'"
    role="alert"
    class="base-motionless-alert success"
    :class="{ 'skeleton-active': !isLoading }"
  >
    <i class="far fa-check"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'error'"
    role="alert"
    class="base-motionless-alert error"
    :class="{ 'skeleton-active': !isLoading }"
  >
    <i class="far fa-times"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'warning'"
    role="alert"
    class="base-motionless-alert warning"
    :class="{ 'skeleton-active': !isLoading }"
  >
    <i class="far fa-exclamation-triangle"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'info'"
    role="alert"
    class="base-motionless-alert info"
    :class="{ 'skeleton-active': isLoading }"
  >
    <i class="far fa-exclamation-circle"></i>
    <span>{{ message }}</span>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "BaseMotionlessAlertComponent",
  props: {
    /**
     * @type {String}
     */
    type: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    message: {
      type: String,
      required: true
    }
  },

  computed: {
    ...mapGetters({
      isLoading: "loading/isLoading"
    })
  }
};
</script>
<style lang="scss">
@import "../../scss/components/motionlessAlert";
</style>
