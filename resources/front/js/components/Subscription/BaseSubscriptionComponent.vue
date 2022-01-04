<template>
  <div class="subscription" :style="getCardStyles">
    <slot name="bang" />
    <div class="subscription-content">
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

      <!-- Subscription options START -->
      <div class="subscription-options">
        <div
          v-for="(option, index) in options"
          :key="index"
          class="subscription__option"
        >
          <svg-alias alias="check-mark-svg" />
          <p class="subscription__option--name">
            {{ option }}
          </p>
        </div>
      </div>
      <!-- Subscription options END -->

      <base-link-button
        link="#"
        class="bg--accent subscription__activate-button"
      >
        Activate
      </base-link-button>
    </div>
  </div>
</template>
<script>
import HexToRgba from "../../modules/HexToRgba";
import BaseLinkButton from "../Buttons/BaseLinkButtonComponent";

export default {
  name: "BaseSubscriptionComponent",
  components: {
    BaseLinkButton
  },

  props: {
    /**
     * Subscription indicator
     *
     * @type {Number}
     */
    id: {
      type: Number,
      required: true
    },

    /**
     * Subscription name
     *
     * @type {String}
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Subscription mini description
     *
     * @type {String}
     */
    description: {
      type: String,
      required: true
    },

    /**
     * Old subscription price
     *
     * @type {Number}
     */
    oldPrice: {
      type: Number,
      required: false
    },

    /**
     * Subscription price
     *
     * @type {Number}
     */
    price: {
      type: Number,
      required: true
    },

    /**
     * Subscription expiration in months
     *
     * @type {Number}
     */
    isValid: {
      type: Number,
      required: true
    },

    /**
     * Options included in this subscription
     *
     * @type {Array}
     */
    options: {
      type: Array,
      required: true
    },

    /**
     * Subscription card background
     *
     * @type {String}
     */
    background: {
      type: String,
      required: false
    }
  },

  computed: {
    getCardStyles() {
      return {
        backgroundColor:
          undefined !== this.background
            ? HexToRgba(this.background, 0.1)
            : undefined
      };
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/subscription";
</style>
