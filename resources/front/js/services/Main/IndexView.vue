<template>
  <div class="content">
    <block-notifications />

    <the-home-header />

    <div class="container">
      <!-- Section advantages START -->
      <section class="out-advantages" aria-label="Advantages">
        <h2 class="out-advantages__title">Our advantages</h2>
        <div class="advantages">
          <advantage-component
            title="Unique features"
            alias-icon="unique-features"
          >
            Since your most unique feature is your brand's voice, build out your
            content using your blog.
          </advantage-component>
          <advantage-component
            title="Subscription price"
            alias-icon="subscription-price"
          >
            Like a rights issue or open offer, it allows shareholders to buy
            additional shares, usually at a fixed price.
          </advantage-component>
          <advantage-component
            title="More options for free subscription"
            alias-icon="more-options"
          >
            A freemium app allows customers to use the app at no cost, with the
            option to subscribe.
          </advantage-component>
          <advantage-component
            title="Unique features"
            alias-icon="unique-features"
          >
            Since your most unique feature is your brand's voice, build out your
            content using your blog.
          </advantage-component>
          <advantage-component
            title="Subscription price"
            alias-icon="subscription-price"
          >
            Like a rights issue or open offer, it allows shareholders to buy
            additional shares, usually at a fixed price.
          </advantage-component>
          <advantage-component
            title="More options for free subscription"
            alias-icon="more-options"
          >
            A freemium app allows customers to use the app at no cost, with the
            option to subscribe.
          </advantage-component>
        </div>
      </section>
      <!-- Section advantages END -->

      <!-- Section subscription START -->
      <section class="subscriptions" aria-label="Subscriptions">
        <h2 class="subscriptions__title">Choose your subscription</h2>
        <p class="subscriptions__text">
          Listen without limits on your phone, speaker and other devices
        </p>

        <!-- Subscriptions -->
        <div class="subscription__cards">
          <base-subscription
            v-for="subscription in subscriptions"
            :key="subscription.id"
            :id="subscription.id"
            :title="subscription.title"
            :description="subscription.description"
            :old-price="subscription.old_price"
            :price="subscription.price"
            :is-valid="subscription.is_valid"
          >
            <template v-if="subscription.bang" #bang>
              <base-subscription-bang
                :title="subscription.bang.title"
                :background="subscription.bang.background"
              />
            </template>
            <template #options>
              <base-subscription-option
                v-for="(option, index) in subscription.options"
                :key="index"
                :name="option"
              />
            </template>
          </base-subscription>
        </div>
      </section>
      <!-- Section subscription END -->
    </div>

    <the-home-footer />
  </div>
</template>

<script>
import BlockNotifications from "../../components/Blocks/FixedAlertsBlock";
import TheHomeHeader from "../../components/Headers/TheHomeHeader";
import AdvantageComponent from "./components/Index/AdvantageComponent";
import BaseSubscription from "../../components/Subscriptions/BaseSubscription";
import BaseSubscriptionBang from "../../components/Subscriptions/BaseSubscriptionBang";
import BaseSubscriptionOption from "../../components/Subscriptions/BaseSubscriptionOption";
import TheHomeFooter from "../../components/Footers/TheHomeFooter";

export default {
  components: {
    BlockNotifications,
    TheHomeHeader,
    AdvantageComponent,
    BaseSubscription,
    BaseSubscriptionBang,
    BaseSubscriptionOption,
    TheHomeFooter
  },

  data: () => ({
    subscriptions: [
      {
        id: 1,
        title: "Basic",
        description: "Essential feature",
        old_price: 59.99,
        price: 53.99,
        is_valid: 5,
        options: [
          "Access to all features",
          "5 Watchlists included",
          "10+ exclusive premium widgets",
          "Priority support",
          "Another great feature"
        ]
      },
      {
        id: 2,
        title: "Basic",
        description: "Essential feature",
        old_price: 59.99,
        price: 53.99,
        is_valid: 5,
        options: [
          "Access to all features",
          "5 Watchlists included",
          "10+ exclusive premium widgets",
          "Priority support",
          "Another great feature"
        ],
        bang: {
          title: "Рекомендуют",
          background: "#3C56D6"
        }
      },
      {
        id: 3,
        title: "Basic",
        description: "Essential feature",
        old_price: 59.99,
        price: 53.99,
        is_valid: 5,
        options: [
          "Access to all features",
          "5 Watchlists included",
          "10+ exclusive premium widgets",
          "Priority support",
          "Another great feature"
        ]
      }
    ]
  })
};
</script>

<style lang="scss">
@import "../../../scss/views/index";
</style>
