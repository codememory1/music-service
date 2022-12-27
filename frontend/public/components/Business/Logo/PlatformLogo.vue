<template>
  <NuxtLink :to="to">
    <img class="platform-logo" src="/images/logo.svg" :alt="$config.title" />
  </NuxtLink>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class PlatformLogo extends Vue {
  @Prop({ required: false, default: '/' })
  private readonly to!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/logo/platform-logo.scss';
</style>
