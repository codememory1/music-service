<template>
  <div class="album" @click="goToAlbum">
    <div class="album-img-wrapper">
      <img :src="data.image" :alt="data.title" class="album__img" />

      <slot name="img-wrapper" />
    </div>
    <div class="album-info">
      <h3 class="album__title">{{ data.title }}</h3>
      <MediaPerformersPart :card-created-at="data.created_at" :performers="data.performers" />
      <slot name="info" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import MediaPerformersPart from '~/components/Business/MediaPart/MediaPerformersPart.vue';

@Component({
  components: {
    MediaPerformersPart
  }
})
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
