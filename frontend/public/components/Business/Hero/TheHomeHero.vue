<template>
  <div class="home-hero">
    <div class="home-hero-info">
      <h1 class="home-hero__header">For your music. The Power of Music</h1>
      <p class="home-hero__description">
        Multifunctional streaming platform with all your conveniences
      </p>
      <BaseButton class="accent home-hero__try-for-free">Try for free</BaseButton>

      <div class="home-hero-statistic-items">
        <div class="home-hero-statistic__item">
          <div class="home-hero-statistic__item-value">100+</div>
          <div class="home-hero-statistic__item-title">Unique features</div>
        </div>
        <div class="home-hero-statistic__item">
          <div class="home-hero-statistic__item-value">Low</div>
          <div class="home-hero-statistic__item-title">Tariff plan prices</div>
        </div>
        <div class="home-hero-statistic__item">
          <div class="home-hero-statistic__item-value rating">
            <span>4.8</span>
            <div class="home-hero-statistic-rating-starts">
              <img
                v-for="num in 5"
                :key="num"
                class="home-hero-statistic-rating__img"
                src="/icons/star.svg"
                :alt="num"
              />
            </div>
          </div>
          <div class="home-hero-statistic__item-title">Rating</div>
        </div>
      </div>
    </div>
    <div class="home-hero-macap-wrapper">
      <img class="home-hero-macap__img" src="/images/mocap.svg" alt="" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class TheHomeHero extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/hero/home-hero.scss';
</style>
