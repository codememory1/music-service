<template>
  <div class="subscription-card">
    <div v-if="isRecommend" class="subscription-card__recommend">
      {{ $t('subscription.recommend') }}
    </div>
    <h3 class="subscription-card__title">{{ title }}</h3>
    <span class="subscription-card__description">{{ description }}</span>

    <span v-if="oldPrice !== null" class="subscription-card__old-price">
      <i class="fas fa-dollar-sign"></i> {{ oldPrice }}
    </span>
    <span class="subscription-card__price"><i class="far fa-dollar-sign"></i> {{ price }}</span>

    <div class="subscription-card-permissions">
      <slot />
    </div>

    <BaseButton class="button_bg--accent subscription-card__buy-btn" @click="$emit('buy', $event)">
      {{ $t('subscription.buy_btn') }}
    </BaseButton>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Buttons/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class SubscriptionCard extends Vue {
  @Prop({ required: true })
  readonly title!: string;

  @Prop({ required: true })
  readonly description!: string;

  @Prop({ required: true })
  readonly price!: number;

  @Prop({ required: false, default: null })
  oldPrice!: number;

  @Prop({ required: false, default: false })
  readonly isRecommend!: boolean;
}
</script>

<style lang="scss">
@import '~/assets/scss/business/subscription/subscription-card';
</style>
