<template>
  <div>
    <base-our-advantage
      icon="unique-feature.svg"
      :title="$t('our_advantage.items.unique_features.title')"
      :description="$t('our_advantage.items.unique_features.description')"
    />
    <base-our-advantage
      icon="subscription-price.svg"
      :title="$t('our_advantage.items.subscription_price.title')"
      :description="$t('our_advantage.items.subscription_price.description')"
    />
    <base-our-advantage
      icon="more-options-for-free-subscription.svg"
      :title="$t('our_advantage.items.options_for_free_subscription.title')"
      :description="$t('our_advantage.items.options_for_free_subscription.description')"
    />
    <base-our-advantage
      icon="listen-to-opinions-users.svg"
      :title="$t('our_advantage.items.listen_to_opinions_users.title')"
      :description="$t('our_advantage.items.listen_to_opinions_users.description')"
    />
    <base-our-advantage
      icon="unique-feature.svg"
      :title="$t('our_advantage.items.unique_features.title')"
      :description="$t('our_advantage.items.unique_features.description')"
    />
    <base-our-advantage
      icon="subscription-price.svg"
      :title="$t('our_advantage.items.subscription_price.title')"
      :description="$t('our_advantage.items.subscription_price.description')"
    />
  </div>
</template>

<script>
import { Component, Vue, Emit } from 'vue-property-decorator';
import SubscriptionCard from '~/components/Business/Subscription/SubscriptionCard';
import SubscriptionPermission from '~/components/Business/Subscription/SubscriptionPermission';
import BaseOurAdvantage from '~/components/Business/OurAdvantage/BaseOurAdvantage';

@Component({
  components: {
    SubscriptionCard,
    SubscriptionPermission,
    BaseOurAdvantage
  }
})
export default class Index extends Vue {
  buy() {
    console.log(123);
  }
}
</script>

<style scoped></style>
