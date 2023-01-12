<template>
  <InformationSection
    class="subscription-section"
    :title="$t('section.subscription.title')"
    :description="$t('section.subscription.description')"
  >
    <BaseSubscription
      v-for="subscription in subscriptions"
      :key="subscription.id"
      :data="subscription"
    />
  </InformationSection>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import InformationSection from '~/components/UI/Section/InformationSection.vue';
import BaseSubscription from '~/components/Business/Subscription/BaseSubscription.vue';
import ApiRequestService from '~/services/business/api-request-service';
import ListSubscriptionResponseType from '~/types/business/api-responses/list-subscription-response-type';
import ListSubscriptionRequest from '~/api/requests/ListSubscriptionRequest';

@Component({
  components: {
    InformationSection,
    BaseSubscription
  },

  async fetch() {
    const that = this as SubscriptionSection;
    const requestService = new ApiRequestService(this);
    const listSubscriptionRequest = new ListSubscriptionRequest(requestService);

    await listSubscriptionRequest.request();

    that.subscriptions = listSubscriptionRequest.getData();
  }
})
export default class SubscriptionSection extends Vue {
  private subscriptions: ListSubscriptionResponseType = [];
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/subscription-section.scss';
</style>
