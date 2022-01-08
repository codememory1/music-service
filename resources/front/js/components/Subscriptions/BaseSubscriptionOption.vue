<template>
  <div class="subscription-option" role="listitem">
    <svg-alias alias="check-mark-svg" />
    <p class="subscription-option__name">{{ name }}</p>
  </div>
</template>

<script>
export default {
  name: "BaseSubscriptionOption",
  props: {
    name: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/subscriptions/base-subscription-option";
</style>
