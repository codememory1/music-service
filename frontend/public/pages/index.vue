<template>
  <div>
    <MainNavigation />
  </div>
</template>

<script>
import { Component, Vue, Emit } from 'vue-property-decorator';
import SubscriptionCard from '~/components/Business/Subscription/SubscriptionCard';
import SubscriptionPermission from '~/components/Business/Subscription/SubscriptionPermission';
import BaseOurAdvantage from '~/components/Business/OurAdvantage/BaseOurAdvantage';
import MainNavigation from '~/components/Business/Navigation/MainNavigation';

@Component({
  components: {
    SubscriptionCard,
    SubscriptionPermission,
    BaseOurAdvantage,
    MainNavigation,
  }
})
export default class Index extends Vue {
  buy() {
    console.log(123);
  }
}
</script>

<style scoped></style>
