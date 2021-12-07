<template>
  <div class="content">
    <!--  Header component -->
    <the-home-header />

    <div class="container">
      <!-- Start sections  advantages -->
      <section class="out-advantages">
        <h2 class="out-advantages__title">Our advantages</h2>
        <div class="advantages">
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/unique-features.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title">Unique features</span>
              <p class="advantage__text">
                Since your most unique feature is your brand's voice, build out
                your content using your blog.
              </p>
            </div>
          </div>
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/subscription-price.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title">Subscription price</span>
              <p class="advantage__text">
                Like a rights issue or open offer, it allows shareholders to buy
                additional shares, usually at a fixed price.
              </p>
            </div>
          </div>
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/more-options.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title"
                >More options for free subscription</span
              >
              <p class="advantage__text">
                A freemium app allows customers to use the app at no cost, with
                the option to subscribe.
              </p>
            </div>
          </div>
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/unique-features.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title">Unique features</span>
              <p class="advantage__text">
                Since your most unique feature is your brand's voice, build out
                your content using your blog.
              </p>
            </div>
          </div>
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/subscription-price.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title">Subscription price</span>
              <p class="advantage__text">
                Like a rights issue or open offer, it allows shareholders to buy
                additional shares, usually at a fixed price.
              </p>
            </div>
          </div>
          <div class="advantage">
            <div class="advantage__icon">
              <inline-svg src="public/images/icons/more-options.svg" />
            </div>
            <div class="advantage__info">
              <span class="advantage__title"
                >More options for free subscription</span
              >
              <p class="advantage__text">
                A freemium app allows customers to use the app at no cost, with
                the option to subscribe.
              </p>
            </div>
          </div>
        </div>
      </section>
      <!-- End sections  advantages -->

      <!-- Start sections subscriptions -->
      <section class="subscriptions">
        <h2 class="subscriptions__title">Choose your subscription</h2>
        <p class="subscriptions__text">
          Listen without limits on your phone, speaker and other devices
        </p>

        <div class="subscription__cards">
          <base-subscription
            id="1"
            title="Basic"
            mini-desc="Essential feature"
            old-price="59.99"
            price="53.99"
            is-valid="5"
            :options="[
              'Access to all features',
              '5 Watchlists included',
              '10+ exclusive premium widgets',
              'Priority support',
              'Another great feature'
            ]"
          />
          <base-subscription
            id="2"
            title="Pro"
            mini-desc="Advanced feature"
            old-price="89.99"
            price="80.99"
            is-valid="5"
            :options="[
              'Access to all features',
              '5 Watchlists included',
              '10+ exclusive premium widgets',
              'Priority support',
              'Another great feature'
            ]"
            background="#3C56D6"
          >
            <template v-slot:bang>
              <subscription-bang title="Рекомендуют" background="#3C56D6" />
            </template>
          </base-subscription>
          <base-subscription
            id="1"
            title="Basic"
            mini-desc="Essential feature"
            old-price="59.99"
            price="53.99"
            is-valid="5"
            :options="[
              'Access to all features',
              '5 Watchlists included',
              '10+ exclusive premium widgets',
              'Priority support',
              'Another great feature'
            ]"
          />
        </div>
      </section>
      <!-- End sections subscriptions -->
    </div>

    <!-- Footer component -->
    <the-footer />
  </div>
</template>
<script>
import TheHomeHeader from "../../components/Headers/TheHomeHeaderComponent";
import BaseSubscription from "../../components/Subscription/BaseSubscriptionComponent";
import SubscriptionBang from "../../components/Subscription/SubscriptionBangComponent";
import TheFooter from "../../components/TheFooterComponent";

export default {
  components: {
    TheHomeHeader,
    BaseSubscription,
    SubscriptionBang,
    TheFooter
  }
};
</script>
<style lang="scss">
@import "../../../scss/views/home";
</style>
