<template>
  <transition name="fade">
    <div v-show="isOpen" class="notification-drop-down">
      <div class="notification-drop-down-inner">
        <div class="notification-drop-down-header">
          <h4 class="notification-drop-down__title">{{ $t('notification_drop_down.title') }}</h4>
          <BaseButton class="notification-drop-down__mark-all-as-read-btn">
            {{ $t('notification_drop_down.mark_all_as_read') }}
          </BaseButton>
        </div>
        <NotificationTabDropDown v-model="activeTab" />

        <div class="notification-drop-down-content">
          <img
            v-if="authorizedUserSession.notifications.length === 0"
            class="notification-drop-down__empty-icon"
            src="/icons/empty-notification.svg"
            alt="Empty"
          />
          <template v-else>
            <template v-if="activeTab === 0">
              <BaseNotificationItemDropDown
                v-for="userNotification in authorizedUserSession.notifications"
                :key="userNotification.id"
                :data="userNotification"
              />
            </template>
          </template>
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import NotificationTabDropDown from '~/components/Business/DropDown/Notification/NotificationTabDropDown.vue';
import BaseNotificationItemDropDown from '~/components/Business/DropDown/Notification/Item/BaseNotificationItemDropDown.vue';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';

@Component({
  components: {
    BaseButton,
    NotificationTabDropDown,
    BaseNotificationItemDropDown
  }
})
export default class NotificationDropDown extends Vue {
  private authorizedUserSession!: AuthorizedUserService;
  private activeTab: number = 0;
  private isOpen: boolean = false;

  public created(): void {
    this.authorizedUserSession = new AuthorizedUserService(this);
  }

  public setIsOpen(is: boolean): void {
    this.isOpen = is;
  }

  public toggleIsOpen(): void {
    this.isOpen = !this.isOpen;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/notification/notification-drop-down.scss';
</style>
