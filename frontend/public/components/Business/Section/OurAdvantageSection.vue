<template>
  <InformationSection class="our-advantages-section" :title="$t('section.our_advantage.title')">
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.unique_features.title')"
      :description="$t('section.our_advantage.items.unique_features.description')"
      icon="icons/our-advantages/feature.svg"
    />
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.subscription_price.title')"
      :description="$t('section.our_advantage.items.subscription_price.description')"
      icon="icons/our-advantages/best-price.svg"
    />
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.more_options_for_free_subscription.title')"
      :description="
        $t('section.our_advantage.items.more_options_for_free_subscription.description')
      "
      icon="icons/our-advantages/options.svg"
    />
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.listen_to_opinions_users.title')"
      :description="$t('section.our_advantage.items.listen_to_opinions_users.description')"
      icon="icons/our-advantages/community.svg"
    />
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.ease_use.title')"
      :description="$t('section.our_advantage.items.ease_use.description')"
      icon="icons/our-advantages/ease-use.svg"
    />
    <BaseOurAdvantage
      :title="$t('section.our_advantage.items.stream_control.title')"
      :description="$t('section.our_advantage.items.stream_control.description')"
      icon="icons/our-advantages/stream.svg"
    />
  </InformationSection>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import InformationSection from '~/components/UI/Section/InformationSection.vue';
import BaseOurAdvantage from '~/components/Business/OurAdvantage/BaseOurAdvantage.vue';

@Component({
  components: {
    InformationSection,
    BaseOurAdvantage
  }
})
export default class OurAdvantageSection extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/our-advantage-section.scss';
</style>
