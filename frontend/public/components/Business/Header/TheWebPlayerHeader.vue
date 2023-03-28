<template>
  <div class="wp-header" :class="{ active }">
    <div class="wp-header-left">
      <div class="wp-header-navigation">
        <BaseButton class="light-dark wp-header-navigation__btn" @click="$emit('prevRoute')">
          <i class="fal fa-chevron-left" />
        </BaseButton>
        <BaseButton class="light-dark wp-header-navigation__btn" @click="$emit('nextRoute')">
          <i class="fal fa-chevron-right" />
        </BaseButton>
      </div>
      <slot />
    </div>
    <div class="wp-header-right">
      <BaseButton
        v-if="authorizedUser === null"
        class="blue wp-header__login-btn"
        @click="$emit('openAuth')"
      >
        {{ $t('navigation.main.signIn') }}
      </BaseButton>

      <div
        v-if="authorizedUser !== null"
        ref="notificationWrapper"
        class="wp-header-notification-wrapper"
      >
        <BaseButton
          class="wp-header__notification-btn"
          @click="$refs.notificationDropDown.toggleIsOpen()"
        >
          <i class="fal fa-bell" />
        </BaseButton>

        <NotificationDropDown ref="notificationDropDown" />
      </div>
      <div v-if="authorizedUser !== null" ref="userWrapper" class="wp-header-user-wrapper">
        <img
          class="wp-header-user__photo"
          :src="authorizedUser.profile.photo"
          :alt="authorizedUser.profile.pseudonym"
          @click="$refs.profileDropDown.toggleIsOpen()"
        />

        <ProfileHeaderDropDown ref="profileDropDown">
          <ProfileHeaderItemDropDown>
            <i class="fal fa-cog" /> {{ $t('navigation.main.manage_account') }}
          </ProfileHeaderItemDropDown>
          <ProfileHeaderItemDropDown @click="authorizedUserService.logout()">
            <i class="fal fa-sign-out" /> {{ $t('navigation.main.logout') }}
          </ProfileHeaderItemDropDown>
        </ProfileHeaderDropDown>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import NotificationDropDown from '~/components/Business/DropDown/Notification/NotificationDropDown.vue';
import ProfileHeaderDropDown from '~/components/Business/DropDown/ProfileHeader/ProfileHeaderDropDown.vue';
import ProfileHeaderItemDropDown from '~/components/Business/DropDown/ProfileHeader/ProfileHeaderItemDropDown.vue';
import clickOut from '~/utils/click-out';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';

@Component({
  components: {
    BaseButton,
    NotificationDropDown,
    ProfileHeaderDropDown,
    ProfileHeaderItemDropDown
  }
})
export default class TheWebPlayerHeader extends Vue {
  @Prop({ required: false, default: false })
  private readonly active!: boolean;

  private authorizedUserService!: AuthorizedUserService;

  public created(): void {
    this.authorizedUserService = new AuthorizedUserService(this);
  }

  private get authorizedUser(): AuthorizedUserInfoResponseInterface | null {
    return this.authorizedUserService.getAuthorizedUser();
  }

  public mounted(): void {
    this.clickOutUserWrapper();
    this.clickOutNotificationWrapper();
  }

  public beforeDestroy(): void {
    document.removeEventListener('click', this.clickOutUserWrapper);
    document.removeEventListener('click', this.clickOutNotificationWrapper);
  }

  private clickOutUserWrapper(): void {
    if (undefined !== this.$refs.userWrapper) {
      clickOut(this.$refs.userWrapper as Node, (is: boolean) => {
        if (is) {
          (this.$refs.profileDropDown as ProfileHeaderDropDown)?.setIsOpen(false);
        }
      });
    }
  }

  private clickOutNotificationWrapper(): void {
    if (undefined !== this.$refs.notificationWrapper) {
      clickOut(this.$refs.notificationWrapper as Node, (is: boolean) => {
        if (is) {
          (this.$refs.notificationDropDown as ProfileHeaderDropDown)?.setIsOpen(false);
        }
      });
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/header/wp-header.scss';
</style>
