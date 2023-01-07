<template>
  <button class="button" :class="{ disabled: isLoading }" @click="$emit('click', $event)">
    <slot v-if="!isLoading" />

    <i v-else class="button__spinner fas fa-spin fa-spinner-third" />
  </button>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseButton extends Vue {
  @Prop({ required: false, default: false })
  private readonly isLoading!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/button/base-button.scss';
</style>
