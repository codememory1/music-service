<template>
  <WebPlayerInformationSection class="slider-cards-section" :title="title">
    <template #top>
      <BaseSliderNavigation
        :prev-active="sliderNavigationService.prevIsActive()"
        :next-active="sliderNavigationService.nextIsActive()"
        @prev="sliderNavigationService.onPrevSlide()"
        @next="sliderNavigationService.onNextSlide()"
      />
    </template>
    <template #content>
      <EmptyContentSection v-if="cards.length === 0">
        <slot name="empty" />
      </EmptyContentSection>
      <core-swiper
        v-else
        ref="swiper"
        :options="swiperOptions"
        @slideChange="sliderNavigationService.onSlideChange()"
      >
        <slide-swiper v-for="(card, index) in cards" :key="index">
          <slot name="card" :item="card" />
        </slide-swiper>
      </core-swiper>
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import BaseSliderNavigation from '~/components/Business/Navigation/Slider/BaseSliderNavigation.vue';
import EmptyContentSection from '~/components/Business/Section/Parts/EmptyContentSection.vue';
import SliderNavigationService from '~/services/ui/slider/slider-navigation-service';

@Component({
  components: {
    WebPlayerInformationSection,
    BaseSliderNavigation,
    EmptyContentSection
  }
})
export default class BaseSliderCardSection extends Vue {
  @Prop({ required: false, default: () => ({ slidesPerView: 'auto' }) })
  private readonly options!: object;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly cards!: Array<object>;

  private sliderNavigationService!: SliderNavigationService;

  public created(): void {
    this.sliderNavigationService = Vue.observable(new SliderNavigationService(this));
  }

  public mounted() {
    this.sliderNavigationService.setSwiper((this.$refs.swiper as any).$swiper);
    this.sliderNavigationService.onSlideChange();
  }

  private get swiperOptions(): object {
    return this.options;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/base-slider-card-section.scss';
</style>
