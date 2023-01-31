<template>
  <li class="profile-header-drop-down__item" @click="$emit('click')">
    <slot />
  </li>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ProfileHeaderItemDropDown extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/profile-header/profile-header-item-drop-down.scss';
</style>
