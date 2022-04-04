<template>
  <div class="subscription">
    <div class="subscription-inner">
      <div class="subscription-top">
        <h3 class="subscription__title">{{ title }}</h3>
        <p class="subscription__description">{{ description }}</p>
      </div>
      <div class="subscription-content">
        <div class="subscription-content-top flex flex-column">
          <span v-if="null !== oldPrice" class="subscription__old-price">
            ${{ oldPrice }}
          </span>
          <span class="subscription__price">${{ oldPrice }}</span>
        </div>
        <div class="subscription-permissions">
          <div
            v-for="(permission, index) in permissions"
            class="subscription__permission relative"
            :class="permission.allowed ? 'allowed' : 'forbidden'"
            :key="index"
          >
            <span class="subscription__permission-text">
              {{ permission.name }}
            </span>
          </div>
        </div>
        <a href="#" class="button bg--accent subscription__buy-btn">
          Buy a subscription
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import {
  arrayValidator,
  objectValidator
} from "~/node_modules/vue-props-validation/src";

export default {
  name: "BaseSubscription",
  props: {
    title: {
      type: String,
      required: true
    },

    description: {
      type: String,
      required: true
    },

    oldPrice: {
      type: Number,
      default: null
    },

    price: {
      type: Number,
      required: true
    },

    permissions: {
      type: Array,
      required: true,
      validator: arrayValidator({
        type: Object,
        validator: objectValidator({
          name: String,
          allowed: Boolean
        })
      })
    }
  }
};
</script>
<style lang="sass">
@import "../../assets/css/components/subscriptions/base-subscription"
</style>
