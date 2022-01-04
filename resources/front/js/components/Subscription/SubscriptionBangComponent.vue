<template>
  <div class="subscription-bang" :style="bangStyles">
    <span>{{ title }}</span>
  </div>
</template>
<script>
export default {
  name: "BaseSubscription",
  props: {
    /**
     * Subscription Bang Name
     *
     * @type {String}
     */
    title: {
      type: String,
      default: "",
      required: false
    },

    /**
     * Bangs background color
     *
     * @type String
     */
    background: {
      type: String,
      default: "",
      required: false
    }
  },

  computed: {
    bangStyles() {
      return {
        backgroundColor: this.background
      };
    }
  }
};
</script>
