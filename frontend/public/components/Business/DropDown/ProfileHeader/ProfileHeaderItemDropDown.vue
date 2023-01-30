<template>
  <li class="profile-header-drop-down__item">
    <nuxt-link class="profile-header-drop-down__item-link" :to="link">
      <slot />
    </nuxt-link>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class ProfileHeaderItemDropDown extends Vue {
  @Prop({ required: true })
  private readonly link!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/profile-header/profile-header-item-drop-down.scss';
</style>
