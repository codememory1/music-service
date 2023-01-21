<template>
  <WebPlayerInformationSection class="top-albums-sections" title="">
    <core-swiper ref="albumsSwiper" :options="swiperOptions">
      <slide-swiper v-for="album in albums" :key="album.id">
        <BaseAlbum :data="album" />
      </slide-swiper>
    </core-swiper>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';

@Component({
  components: {
    WebPlayerInformationSection,
    BaseAlbum
  }
})
export default class TopAlbumSection extends Vue {
  @Prop({ required: true })
  private readonly albums!: Array<AlbumResponseInterface>;

  private get swiperOptions(): object {
    return {
      slidesPerView: 'auto',
      spaceBetween: 15,
      navigation: {
        prevEl: '.prev-top-album__btn',
        nextEl: '.next-top-album__btn'
      }
    };
  }
}
</script>

<style lang="scss"></style>
