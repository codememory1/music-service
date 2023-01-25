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
      <BaseButton class="wp-header__notification-btn">
        <i class="fal fa-bell" />
      </BaseButton>
      <div ref="userWrapper" class="wp-header-user-wrapper">
        <img
          class="wp-header-user__photo"
          src="/images/user.png"
          @click="$refs.profileDropDown.toggleIsOpen()"
        />

        <ProfileHeaderDropDown ref="profileDropDown">
          <ProfileHeaderItemDropDown link="">
            <i class="fal fa-cog" /> {{ $t('navigation.main.manage_account') }}
          </ProfileHeaderItemDropDown>
          <ProfileHeaderItemDropDown link="">
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
import ProfileHeaderDropDown from '~/components/Business/DropDown/ProfileHeader/ProfileHeaderDropDown.vue';
import ProfileHeaderItemDropDown from '~/components/Business/DropDown/ProfileHeader/ProfileHeaderItemDropDown.vue';
import clickOut from '~/utils/click-out';

@Component({
  components: {
    BaseButton,
    ProfileHeaderDropDown,
    ProfileHeaderItemDropDown
  }
})
export default class TheWebPlayerHeader extends Vue {
  @Prop({ required: false, default: false })
  private readonly active!: boolean;

  public mounted(): void {
    this.clickOutDevicePicker();
  }

  public beforeDestroy(): void {
    document.removeEventListener('click', this.clickOutDevicePicker);
  }

  private clickOutDevicePicker(): void {
    clickOut(this.$refs.userWrapper as Node, (is: boolean) => {
      if (is) {
        (this.$refs.profileDropDown as ProfileHeaderDropDown).setIsOpen(false);
      }
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/header/wp-header.scss';
</style>
