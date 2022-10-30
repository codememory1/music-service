<template>
  <div>
    <div class="wrapper-gradient">
      <div class="container">
        <TheMainHeader />
        <TheHomeHero />
      </div>
    </div>
    <div class="container">
      <BaseSection class="our-advantages">
        <template #header>
          <BaseSectionHeader :title="$t('our_advantage.title')" class="our-advantages__header" />
        </template>

        <BaseOurAdvantage
          :title="$t('our_advantage.items.unique_features.title')"
          :description="$t('our_advantage.items.unique_features.description')"
          icon="feature.svg"
        />
        <BaseOurAdvantage
          :title="$t('our_advantage.items.subscription_price.title')"
          :description="$t('our_advantage.items.subscription_price.description')"
          icon="best-price.svg"
        />
        <BaseOurAdvantage
          :title="$t('our_advantage.items.more_options_for_free_subscription.title')"
          :description="$t('our_advantage.items.more_options_for_free_subscription.description')"
          icon="options.svg"
        />
        <BaseOurAdvantage
          :title="$t('our_advantage.items.listen_to_opinions_users.title')"
          :description="$t('our_advantage.items.listen_to_opinions_users.description')"
          icon="community.svg"
        />
        <BaseOurAdvantage
          :title="$t('our_advantage.items.ease_use.title')"
          :description="$t('our_advantage.items.ease_use.description')"
          icon="ease-use.svg"
        />
        <BaseOurAdvantage
          :title="$t('our_advantage.items.stream_control.title')"
          :description="$t('our_advantage.items.stream_control.description')"
          icon="stream.svg"
        />
      </BaseSection>
      <BaseSection class="subscriptions">
        <template #header>
          <BaseSectionHeader
            :title="$t('choose_subscription.title')"
            :description="$t('choose_subscription.description')"
            class="subscriptions__header"
          />
        </template>

        <SubscriptionCard
          v-for="subscription in subscriptions"
          :key="subscription.id"
          :title="subscription.title"
          :description="subscription.description"
          :old-price="subscription.old_price"
          :price="subscription.price"
        >
          <SubscriptionPermission
            v-for="(permission, index) in subscription.permissions"
            :key="index"
            :title="permission.permission_key.title"
          />
        </SubscriptionCard>
      </BaseSection>
    </div>
    <TheMainFooter />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Context } from '@nuxt/types';
import TheMainHeader from '~/components/Business/Header/TheMainHeader.vue';
import TheHomeHero from '~/components/Business/Hero/TheHomeHero.vue';
import BaseSectionHeader from '~/components/UI/Section/BaseSectionHeader.vue';
import BaseSection from '~/components/UI/Section/BaseSection.vue';
import BaseOurAdvantage from '~/components/Business/OurAdvantage/BaseOurAdvantage.vue';
import SubscriptionCard from '~/components/Business/Subscription/SubscriptionCard.vue';
import SubscriptionPermission from '~/components/Business/Subscription/SubscriptionPermission.vue';
import TheMainFooter from '~/components/Business/Footer/TheMainFooter.vue';
import ApiRouters from '~/api/api-routers';

@Component({
  components: {
    TheMainHeader,
    TheHomeHero,
    BaseSectionHeader,
    BaseSection,
    BaseOurAdvantage,
    SubscriptionCard,
    SubscriptionPermission,
    TheMainFooter
  },
  async asyncData({ $api }: Context) {
    const api = await $api(ApiRouters.subscription.all);

    return {
      subscriptions: api.data
    };
  }
})
export default class Index extends Vue {
  private subscriptions = [];
}
</script>

<style lang="scss">
@import '@/assets/scss/pages/home';
</style>
