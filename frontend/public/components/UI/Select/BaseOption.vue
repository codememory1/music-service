<template>
  <li :class="{ active: isActive }" class="select-list__item" @click="$emit('click', $event)">
    <span class="select-list__item-text">{{ value }}</span>
    <i v-if="isActive" class="far fa-check"></i>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseOption extends Vue {
  @Prop({ required: true })
  value!: string | number;

  @Prop({ required: false, default: false })
  isActive!: boolean;
}
</script>

<style lang="scss">
@import "@/assets/scss/ui/select/base-option";
</style>
