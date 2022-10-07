<template>
  <div class="track">
    <div class="track-left">
      <img :src="image" :alt="title" class="track__img" />
      <div class="track-multimedia-info">
        <div class="track__name">{{ title }}</div>
        <span class="track__artists">
          <ArtistLink v-for="artist in artists" :key="artist.id" href="/">
            {{ artist.name }}
          </ArtistLink>
        </span>
      </div>
    </div>
    <div class="track-right">
      <span class="track__duration-time">{{ duration }}</span>
      <div class="track-control">
        <BaseButton class="track__btn track__like-btn">
          <i class="fas fa-thumbs-up" />
        </BaseButton>
        <BaseButton class="track__btn track__menu-btn">
          <i class="fas fa-ellipsis-v"></i>
        </BaseButton>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import ArtistLink from '~/components/Business/Link/ArtistLink.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { ArtistType } from '~/types/ArtistType';

@Component({
  components: {
    ArtistLink,
    BaseButton
  }
})
export default class BaseTrack extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly image!: string;

  @Prop({ required: true })
  private readonly artists!: ArtistType[];

  @Prop({ required: true })
  private readonly duration!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/track/base-track';
</style>
