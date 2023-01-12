<template>
  <div class="home-hero"></div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class TheHomeHero extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/hero/home-hero.scss';
</style>
