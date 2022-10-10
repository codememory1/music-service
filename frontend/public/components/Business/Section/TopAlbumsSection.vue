<template>
  <BaseSection class="top-albums">
    <template #header>
      <BaseSectionHeader title="Weeklly Top Track" class="top-albums__header">
        <div class="slider-navigation">
          <PrevButton @click="prev" />
          <NextButton @click="next" />
        </div>
      </BaseSectionHeader>
    </template>

    <core-swiper ref="albumsSwiper" :options="swiperOptions">
      <slide-swiper v-for="album in albums" :key="album.id">
        <BaseAlbum :data="album" />
      </slide-swiper>
    </core-swiper>
  </BaseSection>
</template>

<script lang="ts">
import { Component, Vue as VueDecorator, Prop } from 'vue-property-decorator';
import { AlbumType } from '~/types/AlbumType';
import BaseSection from '~/components/UI/Section/BaseSection.vue';
import BaseSectionHeader from '~/components/UI/Section/BaseSectionHeader.vue';
import PrevButton from '~/components/Business/Button/PrevButton.vue';
import NextButton from '~/components/Business/Button/NextButton.vue';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';

@Component({
  components: {
    BaseSection,
    BaseSectionHeader,
    PrevButton,
    NextButton,
    BaseAlbum
  }
})
export default class TopAlbumsSection extends VueDecorator {
  @Prop({ required: true })
  private readonly albums!: AlbumType[];

  get swiper(): object {
    return this.$refs.albumsSwiper.$swiper;
  }

  get swiperOptions(): object {
    return {
      slidesPerView: 5,
      spaceBetween: 12
    };
  }

  private prev(): void {
    this.swiper.$swiper.slidePrev();
  }

  private next(): void {
    this.swiper.$swiper.slideNext();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/section/top-albums-section';
</style>
