<template>
  <WebPlayerInformationSection class="top-albums-section" :title="$t('artist.top_albums')">
    <template #top>
      <BaseSliderNavigation
        :prev-active="prevIsActive"
        :next-active="nextIsActive"
        @prev="prev"
        @next="next"
      />
    </template>
    <template #content>
      <core-swiper ref="swiper" :options="swiperOptions" @slideChange="change">
        <slide-swiper v-for="album in albums" :key="album.id">
          <BaseAlbum :data="album" />
        </slide-swiper>
      </core-swiper>
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import BaseSliderNavigation from '~/components/Business/Navigation/Slider/BaseSliderNavigation.vue';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';

@Component({
  components: {
    WebPlayerInformationSection,
    BaseSliderNavigation,
    BaseAlbum
  }
})
export default class TopAlbumSection extends Vue {
  @Prop({ required: true })
  private readonly albums!: Array<AlbumResponseInterface>;

  private get swiperOptions(): object {
    return {
      slidesPerView: 5,
      spaceBetween: 15
    };
  }

  private swiper!: any;
  private prevIsActive: boolean = false;
  private nextIsActive: boolean = false;

  public mounted() {
    this.swiper = (this.$refs.swiper as any).$swiper;

    this.change();
  }

  private prev(): void {
    this.swiper.slidePrev();
  }

  private next(): void {
    this.swiper.slideNext();
  }

  private change(): void {
    this.prevIsActive = this.swiper.activeIndex > 0;
    this.nextIsActive = !this.swiper.isEnd;
  }
}
</script>

<style>
@import '@/assets/scss/components/business/section/top-album-section.scss';
</style>
