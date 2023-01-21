<template>
  <BaseAlbum :data="data" class="single-album">
    <template #img-wrapper>
      <BaseButton class="blue single-album__play-btn" @click="play">
        <i class="fal fa-play" />
      </BaseButton>
    </template>
  </BaseAlbum>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton,
    BaseAlbum
  }
})
export default class SingleAlbum extends Vue {
  @Prop({ required: true })
  private readonly data!: AlbumResponseInterface;

  private play(event: PointerEvent): void {
    event.stopPropagation();

    // TODO: Play first music
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/album/single-album.scss';
</style>
