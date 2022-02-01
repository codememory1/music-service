<template>
  <div class="subscription-bang" :style="styles">
    <span class="subscription-bang__title">{{ title }}</span>
  </div>
</template>

<script>
export default {
  name: "BaseSubscriptionBang",
  props: {
    /**
     * Bang Title
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Bang background
     */
    background: {
      type: String,
      default: null
    }
  },

  computed: {
    /**
     * @returns {{backgroundColor: (string|string)}}
     */
    styles() {
      return {
        backgroundColor: this.background ?? "var(--accent)"
      };
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/subscriptions/base-subscription-bang";
</style>
