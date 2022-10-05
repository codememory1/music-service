<template>
  <div>
    <div class="wrapper-gradient">
      <div class="container">
        <TheMainHeader />
        <TheHomeHero />
      </div>
    </div>
    <div class="container">
      <BaseSection title="Our advantages" class="our-advantages">
        <div class="our-advantages-list">
          <BaseOurAdvantage
            title="Unique features"
            description="Since your most unique feature is your brand's voice, build out your content using your blog."
            icon="unique-feature.svg"
          />
          <BaseOurAdvantage
            title="Subscription price"
            description="Like a rights issue or open offer, it allows shareholders to buy additional shares, usually at a fixed price."
            icon="subscription-price.svg"
          />
          <BaseOurAdvantage
            title="More options for free subscription"
            description="A freemium app allows customers to use the app at no cost, with the option to subscribe."
            icon="more-options-for-free-subscription.svg"
          />
          <BaseOurAdvantage
            title="We listen to the opinions of users"
            description="When we spoke of individual journalists, it was often specific to outspoken personalities and opinion writers."
            icon="listen-to-opinions-users.svg"
          />
          <BaseOurAdvantage
            title="Unique features"
            description="Since your most unique feature is your brand's voice, build out your content using your blog."
            icon="unique-feature.svg"
          />
          <BaseOurAdvantage
            title="Subscription price"
            description="Like a rights issue or open offer, it allows shareholders to buy additional shares, usually at a fixed price."
            icon="subscription-price.svg"
          />
        </div>
      </BaseSection>
      <BaseSection
        title="Choose your subscription"
        description="Listen without limits on your phone, speaker and other devices"
      >
        <div class="subscription-list">
          <SubscriptionCard
            title="Basic"
            description="Essential feature"
            :old-price="59.99"
            :price="53.99"
          >
            <SubscriptionPermission title="Access to all features" />
            <SubscriptionPermission title="5 Watchlists included" />
            <SubscriptionPermission title="10+ exclusive premium widgets" :has="false" />
            <SubscriptionPermission title="Priority support" />
            <SubscriptionPermission title="Another great feature" />
          </SubscriptionCard>
          <SubscriptionCard
            title="Pro"
            description="Advanced feature"
            :old-price="89.99"
            :price="80.99"
            :is-recommend="true"
          >
            <SubscriptionPermission title="Access to all features" />
            <SubscriptionPermission title="5 Watchlists included" />
            <SubscriptionPermission title="10+ exclusive premium widgets" :has="false" />
            <SubscriptionPermission title="Priority support" />
            <SubscriptionPermission title="Another great feature" />
          </SubscriptionCard>
          <SubscriptionCard
            title="Basic"
            description="Essential feature"
            :old-price="59.99"
            :price="53.99"
          >
            <SubscriptionPermission title="Access to all features" />
            <SubscriptionPermission title="5 Watchlists included" />
            <SubscriptionPermission title="10+ exclusive premium widgets" :has="false" />
            <SubscriptionPermission title="Priority support" />
            <SubscriptionPermission title="Another great feature" />
          </SubscriptionCard>
        </div>
      </BaseSection>
    </div>
    <TheMainFooter />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheMainHeader from '~/components/Business/Header/TheMainHeader.vue';
import TheHomeHero from '~/components/Business/Hero/TheHomeHero.vue';
import BaseSection from '~/components/UI/Section/BaseSection.vue';
import BaseOurAdvantage from '~/components/Business/OurAdvantage/BaseOurAdvantage.vue';
import SubscriptionCard from '~/components/Business/Subscription/SubscriptionCard.vue';
import SubscriptionPermission from '~/components/Business/Subscription/SubscriptionPermission.vue';
import TheMainFooter from '~/components/Business/Footer/TheMainFooter.vue';

@Component({
  components: {
    TheMainHeader,
    TheHomeHero,
    BaseSection,
    BaseOurAdvantage,
    SubscriptionCard,
    SubscriptionPermission,
    TheMainFooter
  }
})
export default class Index extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/pages/home';
</style>
