<template>
  <div class="subscription-card-permission">
    <img
      v-if="has"
      class="subscription-card-permission__icon"
      src="~/static/icons/check-mark.svg"
      alt="has"
    />
    <img
      v-else
      class="subscription-card-permission__icon"
      src="~/static/icons/close.svg"
      alt="not has"
    />

    <span class="subscription-card-permission__title">{{ title }}</span>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class SubscriptionPermission extends Vue {
  @Prop({ required: true })
  readonly title!: string;

  @Prop({ required: false, default: true })
  readonly has!: boolean;
}
</script>

<style lang="scss">
@import '~/assets/scss/subscription/subscription-permission';
</style>
