<template>
  <BaseAlbum :data="data" class="single-album">
    <template #img-wrapper>
      <CirclePlayButton class="single-album__play-btn" @click.stop="$emit('play', data)" />
    </template>
  </BaseAlbum>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import CirclePlayButton from '~/components/Business/Button/CirclePlayButton.vue';

@Component({
  components: {
    CirclePlayButton,
    BaseAlbum
  }
})
export default class SingleAlbum extends Vue {
  @Prop({ required: true })
  private readonly data!: AlbumResponseInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/album/single-album.scss';
</style>
