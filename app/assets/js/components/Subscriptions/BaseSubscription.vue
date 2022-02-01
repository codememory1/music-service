<template>
  <div class="subscription" :style="styles">
    <slot name="bang" />

    <!-- Content START -->
    <div class="subscription-content">
      <!-- Info START -->
      <h3 class="subscription__title">
        {{ title }}
      </h3>
      <p class="subscription__description">
        {{ description }}
      </p>
      <span v-if="undefined !== oldPrice" class="subscription__old-price">
        ${{ oldPrice }}
      </span>
      <span class="subscription__price">${{ price }}</span>
      <span class="subscription__acts">
        Subscription is valid for {{ isValid }} months
      </span>
      <!-- Info END -->

      <!-- Subscription options START -->
      <div class="subscription-options" role="list">
        <slot name="options" />
      </div>
      <!-- Subscription options END -->

      <base-link-button
        link="#"
        class="bg--accent subscription__activate-button"
      >
        Activate
      </base-link-button>
    </div>
    <!-- Content END -->
  </div>
</template>

<script>
import BaseLinkButton from "../Buttons/BaseLinkButton";
import HexToRgba from "../../modules/helpers/HexToRgba";

export default {
  name: "BaseSubscription",
  components: {
    BaseLinkButton
  },
  props: {
    /**
     * Unique identificator
     */
    id: {
      type: Number,
      required: true
    },

    /**
     * Subscription title
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Subscription description
     */
    description: {
      type: String,
      required: true
    },

    /**
     * Old subscription price
     */
    oldPrice: {
      type: Number,
      required: false
    },

    /**
     * Subscription price
     */
    price: {
      type: Number,
      required: true
    },

    /**
     * Subscription expiration in months
     */
    isValid: {
      type: Number,
      required: true
    },

    /**
     * Subscription card background
     */
    background: {
      type: String,
      required: false
    }
  },

  computed: {
    /**
     * @returns {{backgroundColor: (string|*)}}
     */
    styles() {
      const color = this.background ?? "var(--blue)";

      return {
        backgroundColor: HexToRgba(color, 0.1)
      };
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/subscriptions/base-subscription";
</style>
