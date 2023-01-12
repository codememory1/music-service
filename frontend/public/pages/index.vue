<template>
  <main class="main">
    <div class="container">
      <TheMainHeader>
        <template #navigation>
          <TheMainNavigation />
        </template>
      </TheMainHeader>
      <OurAdvantageSection />
      <SubscriptionSection />
    </div>
    <TheMainFooter />
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheMainHeader from '~/components/Business/Header/TheMainHeader.vue';
import TheMainNavigation from '~/components/Business/Navigation/Main/TheMainNavigation.vue';
import OurAdvantageSection from '~/components/Business/Section/OurAdvantageSection.vue';
import SubscriptionSection from '~/components/Business/Section/SubscriptionSection.vue';
import TheMainFooter from '~/components/Business/Footer/Main/TheMainFooter.vue';

@Component({
  components: {
    TheMainHeader,
    TheMainNavigation,
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
