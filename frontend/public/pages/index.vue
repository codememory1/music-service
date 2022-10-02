<template>
  <div>
    <SubscriptionCard
      title="Первая подписка"
      description="Описание подписки"
      :old-price="59.99"
      :price="49.99"
    >
      <SubscriptionPermission title="Добавление мультимедиа" />
      <SubscriptionPermission title="Конструктор дизайна профиля" />
      <SubscriptionPermission title="Удаление друзей" :has="false" />
    </SubscriptionCard>
  </div>
</template>

<script>
import SubscriptionCard from '~/components/Subscription/SubscriptionCard';
import SubscriptionPermission from '~/components/Subscription/SubscriptionPermission';

export default {
  name: 'Index',
  components: { SubscriptionCard, SubscriptionPermission }
};
</script>

<style scoped></style>
