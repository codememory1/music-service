<template>
  <BaseSection class="top-albums">
    <template #header>
      <BaseSectionHeader title="Weeklly Top Track" class="top-albums__header">
        <div class="slider-navigation">
          <PrevButton class="prev-top-album__btn" />
          <NextButton class="next-top-album__btn" />
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
import { Component, Vue, Prop } from 'vue-property-decorator';
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
export default class TopAlbumsSection extends Vue {
  @Prop({ required: true })
  private readonly albums!: AlbumType[];

  get swiper(): Vue {
    return this.$refs.albumsSwiper as Vue;
  }

  get swiperOptions(): object {
    return {
      slidesPerView: 5,
      spaceBetween: 12,
      navigation: {
        prevEl: '.prev-top-album__btn',
        nextEl: '.next-top-album__btn'
      }
    };
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/section/top-albums-section';
</style>
