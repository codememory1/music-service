<template>
  <div class="track">
    <div class="track-left">
      <img :src="data.image" :alt="data.title" class="track__img" />
      <div class="track-multimedia-info">
        <div class="track__name">{{ data.title }}</div>
        <span class="track__artists">
          <ArtistLink v-for="performer in data.performers" :key="performer.id" href="/">
            {{ performer.name }}
          </ArtistLink>
        </span>
      </div>
    </div>
    <div class="track-right">
      <span class="track__duration-time">{{ data.duration }}</span>
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
import { TrackType } from '~/types/TrackType';

@Component({
  components: {
    ArtistLink,
    BaseButton
  }
})
export default class BaseTrack extends Vue {
  @Prop({ required: true })
  private readonly data!: TrackType;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/track/base-track';
</style>
