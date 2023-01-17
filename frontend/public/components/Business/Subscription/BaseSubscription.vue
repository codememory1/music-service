<template>
  <div class="subscription">
    <div class="subscription-inner">
      <div class="subscription-basic-info">
        <h3 class="subscription__title">{{ data.title }}</h3>
        <p class="subscription__description">{{ data.description }}</p>
      </div>
      <div class="subscription-price">
        <span v-if="data.old_price !== null" class="subscription__old-price">
          <i class="far fa-dollar-sign" />{{ data.old_price }}
        </span>
        <span class="subscription__purchase-price">
          <i class="far fa-dollar-sign" />{{ data.price }}
        </span>
      </div>
      <p class="subscription__validity">Valid for 1 month</p>
      <div class="subscription-permission-list">
        <BasePermissionSubscription
          v-for="(title, index) in data.ui_permissions"
          :key="index"
          :title="title"
        />
      </div>
      <BaseButton class="accent subscription__buy-btn" @click="buySubscriptionService.buy">
        {{ $t('buttons.buy_subscription') }}
      </BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import SubscriptionResponseInterface from '~/interfaces/business/api-responses/subscription-response-interface';
import BasePermissionSubscription from '~/components/Business/Subscription/BasePermissionSubscription.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BuySubscriptionService from '~/services/business/subscription/buy-subscription-service';

@Component({
  components: {
    BasePermissionSubscription,
    BaseButton
  }
})
export default class BaseSubscription extends Vue {
  @Prop({ required: true })
  private readonly data!: SubscriptionResponseInterface;

  private readonly buySubscriptionService: BuySubscriptionService = new BuySubscriptionService(
    this,
    this.data
  );
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/subscription/base-subscription.scss';
</style>
