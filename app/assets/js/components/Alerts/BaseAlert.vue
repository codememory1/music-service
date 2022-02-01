<template>
  <div
    v-if="type === 'success'"
    role="alert"
    class="motionless-alert success"
    :class="{ 'skeleton-active': !isCameTranslation }"
  >
    <i class="far fa-check"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'error'"
    role="alert"
    class="motionless-alert error"
    :class="{ 'skeleton-active': !isCameTranslation }"
  >
    <i class="far fa-times"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'warning'"
    role="alert"
    class="motionless-alert warning"
    :class="{ 'skeleton-active': !isCameTranslation }"
  >
    <i class="far fa-exclamation-triangle"></i>
    <span>{{ message }}</span>
  </div>
  <div
    v-else-if="type === 'info'"
    role="alert"
    class="motionless-alert info"
    :class="{ 'skeleton-active': !isCameTranslation }"
  >
    <i class="far fa-exclamation-circle"></i>
    <span>{{ message }}</span>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "BaseAlert",
  props: {
    /**
     * Alert type
     *
     * Types: success, error, warning, info
     */
    type: {
      type: String,
      required: true
    },

    /**
     * Alert message
     */
    message: {
      type: String,
      required: true
    }
  },

  computed: {
    ...mapGetters({
      isCameTranslation: "requestStatuses/isCameTranslation"
    })
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/alerts/base-alert";
</style>
