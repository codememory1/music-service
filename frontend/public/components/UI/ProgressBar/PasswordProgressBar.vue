<template>
  <div class="password-progress-bar">
    <span
      v-for="i in countItems"
      :key="i"
      class="password-progress-bar__item"
      :class="{ active: i <= countActive }"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class PasswordProgressBar extends Vue {
  @Prop({ required: false, default: 5 })
  private readonly countItems!: number;

  @Prop({ required: false, default: 0 })
  private readonly countActive!: number;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/progress-bar/password-progress-bar';
</style>
