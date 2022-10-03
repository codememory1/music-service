<template>
  <button class="button" @click="$emit('click', $event)">
    <slot />
  </button>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseButton extends Vue {}
</script>

<style lang="scss">
@import '~/assets/scss/ui/buttons/base-button';
</style>
