<template>
  <section class="section">
    <div class="section-header">
      <div class="section-header-inner">
        <h3 class="section__title">{{ title }}</h3>
        <p class="section__description">{{ description }}</p>
      </div>

      <slot name="header" />
    </div>

    <div class="section-content">
      <slot />
    </div>
  </section>
</template>

<script>
import { Component, Vue } from 'vue-property-decorator';
import 'swiper/css/swiper.css';

@Component
export default class TopAlbums extends Vue {}
</script>

<style scoped></style>
