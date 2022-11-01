<template>
  <div class="notification-list">
    <div class="notification-list__wrapper">
      <div class="notification-list__top">
        <h4 class="notification-list__title">Notifications</h4>
        <BaseButton class="notification-list__read-all-btn" tabindex="-1">
          Mark all as read
        </BaseButton>
      </div>
      <div class="notification-list__content">
        <slot>
          <div class="notification-list-empty-wrapper">
            <img src="/icons/empty-notification.svg" alt="Empty" />
            <p>Notification list is empty</p>
          </div>
        </slot>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class NotificationList extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/notification/notification-list';
</style>
