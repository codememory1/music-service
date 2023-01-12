<template>
  <div class="main-footer-row__item">
    <nuxt-link class="main-footer-row__item-link" :to="link">{{ title }}</nuxt-link>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class MainRowItemFooter extends Vue {
  @Prop({ required: true })
  private readonly link!: string;

  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/footer/main/main-row-item-footer.scss';
</style>
