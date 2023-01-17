<template>
  <ul class="main-navigation-drop-down">
    <slot />
  </ul>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class DropDownMainNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/main/drop-down-main-navigation.scss';
</style>
