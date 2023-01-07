<template>
  <form class="modal-form">
    <slot />
  </form>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ModalForm extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form/modal-form.scss';
</style>
