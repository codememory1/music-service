<template>
  <div class="album" @click="goToAlbum">
    <div class="album-img-wrapper">
      <img :src="data.image" :alt="data.title" class="album__img" />

      <slot name="img-wrapper" />
    </div>
    <div class="album-info">
      <h3 class="album__title">{{ data.title }}</h3>
      <div class="album-performer-wrapper">
        <time class="album__year-creation" :datetime="data.created_at">{{ data.created_at }}</time>
        <span v-for="(performer, index) in data.performers" :key="index" class="album__performer">
          <nuxt-link class="album__performer-link" to="">
            {{ performer.title }}
          </nuxt-link>
          <template v-if="index < data.performers.length - 1">&</template>
        </span>
      </div>

      <slot name="info" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';

@Component
export default class BaseAlbum extends Vue {
  @Prop({ required: true })
  private readonly data!: AlbumResponseInterface;

  private goToAlbum(): void {
    // TODO: Redirect to route album
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/album/base-album.scss';
</style>
