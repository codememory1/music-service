<template>
  <div class="subscription" :style="getCardStyles">
    <slot name="bang" />
    <div class="subscription__content">
      <h3 class="subscription__title">
        {{ title }}
      </h3>
      <h3 class="subscription__mini-desc">
        {{ miniDesc }}
      </h3>
      <span v-if="undefined !== oldPrice" class="subscription__old-price"
        >${{ oldPrice }}</span
      >
      <span class="subscription__price">${{ price }}</span>
      <span class="subscription__is-valid"
        >Subscription is valid for {{ isValid }} months</span
      >
      <div class="subscription__options">
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
      <a href="#" class="subscription__activate-button">Activate</a>
    </div>
  </div>
</template>
<script>
import HexToRgba from "../../modules/HexToRgba";

export default {
  name: "BaseSubscription",
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
    miniDesc: {
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
