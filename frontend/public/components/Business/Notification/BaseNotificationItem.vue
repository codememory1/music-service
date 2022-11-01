<template>
  <div class="notification-list-item">
    <div class="notification-list-item__user-photo">
      <img :src="userPhoto" :alt="userName" />
    </div>
    <div class="notification-list-item__content">
      <div class="notification-list-item__content-top">
        <span class="notification-list-item__user-name">{{ userName }}</span>
        <span class="notification-list-item__create-at">{{ createdAt }}</span>
      </div>
      <div class="notification-list-item__content-down">
        <p class="notification-list-item__description">{{ content }}</p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseNotificationItem extends Vue {
  @Prop({ required: true })
  private readonly userName!: string;

  @Prop({ required: true })
  private readonly userPhoto!: string;

  @Prop({ required: false, default: false })
  private readonly isOnline: boolean = false;

  @Prop({ required: true })
  private readonly content!: string;

  @Prop({ required: true })
  private readonly createdAt!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/notification/base-otification-list-item';
</style>
