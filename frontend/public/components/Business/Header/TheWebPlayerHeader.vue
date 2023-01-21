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
      <div class="wp-header-user-wrapper">
        <img class="wp-header-user__photo" src="/images/user.png" alt="codememory" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class TheWebPlayerHeader extends Vue {
  @Prop({ required: false, default: false })
  private readonly active!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/header/wp-header.scss';
</style>
