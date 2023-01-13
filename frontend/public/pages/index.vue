<template>
  <main class="index-main">
    <ListInformationSection>
      <div class="home-header-wrapper">
        <div class="container">
          <ListInformationSection>
            <TheMainHeader>
              <TheMainNavigation>
                <MainItemNavigation link="" :title="$t('navigation.main.premium')" />
                <MainItemNavigation link="" :title="$t('navigation.main.support')" />
                <MainItemNavigation link="" :title="$t('navigation.main.signUp')" />
                <MainItemNavigation link="" :title="$t('navigation.main.signIn')" />
              </TheMainNavigation>
            </TheMainHeader>
            <TheHomeHero />
          </ListInformationSection>
        </div>
      </div>

      <div class="container">
        <ListInformationSection>
          <OurAdvantageSection />
          <SubscriptionSection />
        </ListInformationSection>
      </div>

      <TheMainFooter />
    </ListInformationSection>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheMainHeader from '~/components/Business/Header/TheMainHeader.vue';
import TheHomeHero from '~/components/Business/Hero/TheHomeHero.vue';
import ListInformationSection from '~/components/Business/List/ListInformationSection.vue';
import TheMainNavigation from '~/components/Business/Navigation/Main/TheMainNavigation.vue';
import MainItemNavigation from '~/components/Business/Navigation/Main/MainItemNavigation.vue';
import OurAdvantageSection from '~/components/Business/Section/OurAdvantageSection.vue';
import SubscriptionSection from '~/components/Business/Section/SubscriptionSection.vue';
import TheMainFooter from '~/components/Business/Footer/Main/TheMainFooter.vue';

@Component({
  components: {
    TheMainHeader,
    TheHomeHero,
    ListInformationSection,
    TheMainNavigation,
    MainItemNavigation,
    OurAdvantageSection,
    SubscriptionSection,
    TheMainFooter
  }
})
export default class Index extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/pages/index.scss';
</style>
