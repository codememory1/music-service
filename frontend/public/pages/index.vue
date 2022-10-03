<template>
  <div>
    <SubscriptionCard
      title="Первая подписка"
      description="Описание подписки"
      :old-price="59.99"
      :price="49.99"
      @buy="buy"
    >
      <SubscriptionPermission title="Добавление мультимедиа" />
      <SubscriptionPermission title="Конструктор дизайна профиля" />
      <SubscriptionPermission title="Удаление друзей" :has="false" />
    </SubscriptionCard>
  </div>
</template>

<script>
import { Component, Vue, Emit } from 'vue-property-decorator';
import SubscriptionCard from '~/components/Business/Subscription/SubscriptionCard';
import SubscriptionPermission from '~/components/Business/Subscription/SubscriptionPermission';

@Component({
  components: {
    SubscriptionCard,
    SubscriptionPermission
  }
})
export default class Index extends Vue {
  buy() {
    console.log(123);
  }
}
</script>

<style scoped></style>
