<template>
  <div class="our-advantage">
    <img class="our-advantage__icon" :src="'/icons/our-advantages/' + icon" :alt="title" />
    <div class="our-advantage-info">
      <span class="our-advantage__title">{{ title }}</span>
      <p class="our-advantage__description">{{ description }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

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
@import '@/assets/scss/business/our-advantage/base-our-advantage';
</style>
