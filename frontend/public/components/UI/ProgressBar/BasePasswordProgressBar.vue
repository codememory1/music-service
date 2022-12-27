<template>
  <div class="password-progress-bar">
    <span
      v-for="(levelName, index) in level"
      :key="index"
      class="password-progress-bar__item"
      :class="levelName"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class PasswordProgressBar extends Vue {
  @Prop({ required: true })
  private readonly level!: Array<string>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/progress-bar/base-password-progress-bar.scss';
</style>
