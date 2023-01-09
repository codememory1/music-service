<template>
  <InformationSection
    :title="$t('section.subscription.title')"
    :description="$t('section.subscription.description')"
  >
  </InformationSection>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import InformationSection from '~/components/UI/Section/InformationSection.vue';

@Component({
  components: {
    InformationSection
  }
})
export default class SubscriptionSection extends Vue {}
</script>

<style lang="scss"></style>
