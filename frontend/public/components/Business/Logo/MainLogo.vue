<template>
  <NuxtLink to="/">
    <img class="horizontal-logo" :class="logoClass" src="/images/logo.svg" :alt="$config.title" />
  </NuxtLink>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class MainLogo extends Vue {
  @Prop({ required: false, default: () => {} })
  private readonly logoClass!: object;
}
</script>
