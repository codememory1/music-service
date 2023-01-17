<template>
  <div class="our-advantage-item">
    <div class="our-advantage-item-icon-wrapper">
      <nuxt-img class="our-advantage-item__icon" :src="icon" />
    </div>
    <div class="our-advantage-item-info-wrapper">
      <h4 class="our-advantage-item__title">{{ title }}</h4>
      <p class="our-advantage-item__description">{{ description }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseOurAdvantage extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly description!: string;

  @Prop({ required: true })
  private readonly icon!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/our-advantage/base-our-advantage.scss';
</style>
