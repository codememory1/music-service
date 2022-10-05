<template>
  <section class="hero">
    <div class="hero-content">
      <h1 class="hero-content__title">Listening is everything in your life</h1>
      <p class="hero-content__description">
        Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card.
      </p>
      <a href="" class="button button_bg--accent hero-content__btn">Create account</a>
    </div>
    <div class="hero-mockup">
      <img class="hero-mockup__img" src="~/assets/images/mockup.png" alt="">
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

export default class TheHomeHero extends Vue {}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/business/hero/the-home-hero';
</style>
