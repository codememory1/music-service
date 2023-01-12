<template>
  <div class="subscription-permission">
    <nuxt-img class="subscription-permission__icon" src="icons/check-mark.svg" />
    <span class="subscription-permission__title">{{ data.permission_key.title }}</span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { SubscriptionPermissionInterface } from '~/interfaces/business/api-responses/list-subscription-response-interface';

@Component
export default class BasePermissionSubscription extends Vue {
  @Prop({ required: true })
  private readonly data!: SubscriptionPermissionInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/subscription/base-permission-subscription.scss';
</style>
