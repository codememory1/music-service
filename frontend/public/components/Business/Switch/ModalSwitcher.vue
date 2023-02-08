<template>
  <div class="modal-switcher">
    <p class="modal-switcher__text">
      <slot />
    </p>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ModalSwitcher extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/switch/modal-switcher.scss';
</style>
