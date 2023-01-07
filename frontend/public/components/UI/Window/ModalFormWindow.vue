<template>
  <div class="modal-form-window">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ModalFormWindow extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/window/base-modal-form-window.scss';
</style>
