<template>
  <transition name="fade">
    <div v-show="isOpen" ref="dropDown" class="profile-header-drop-down">
      <div class="profile-header-drop-down-inner">
        <ul class="profile-header-drop-down-items">
          <slot />
        </ul>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ProfileHeaderDropDown extends Vue {
  private isOpen: boolean = false;

  public toggleIsOpen(): void {
    this.isOpen = !this.isOpen;
  }

  public setIsOpen(is: boolean): void {
    this.isOpen = is;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/profile-header/profile-header-drop-down.scss';
</style>
