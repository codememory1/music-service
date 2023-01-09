<template>
  <div class="subscription">
    <div class="subscription-inner">
      <div class="subscription-basic-info">
        <h3 class="subscription__title">{{ data.title }}</h3>
        <p class="subscription__description">{{ data.description }}</p>
      </div>
      <div class="subscription-price">
        <span v-if="data.old_price !== null" class="subscription__old-price">
          {{ data.old_price }}
        </span>
        <span class="subscription__purchase-price">{{ data.price }}</span>
      </div>
      <div class="subscription-permission-list">
        <BasePermissionSubscription
          v-for="(permission, index) in data.permissions"
          :key="index"
          :data="permission"
        />
      </div>
      <BaseButton class="subscription__buy-btn">{{ $t('buttons.buy_subscription') }}</BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { SubscriptionInterface } from '~/interfaces/business/api-responses/list-subscription-response-interface';
import BasePermissionSubscription from '~/components/Business/Subscription/BasePermissionSubscription.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BasePermissionSubscription,
    BaseButton
  }
})
export default class BaseSubscription extends Vue {
  @Prop({ required: true })
  private readonly data!: SubscriptionInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/subscription/base-subscription.scss';
</style>
