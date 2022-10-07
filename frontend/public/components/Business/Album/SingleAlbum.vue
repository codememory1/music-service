<template>
  <BaseAlbum :id="id" :title="title" :image="image" :artists="artists">
    <BaseButton class="album__play-btn">
      <i v-if="!isPlay" class="fas fa-play"></i>
      <i v-else class="fas fa-pause"></i>
    </BaseButton>
  </BaseAlbum>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { ArtistType } from '../../../types/ArtistType';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import BaseButton from "~/components/UI/Button/BaseButton.vue";

@Component({
  components: {
    BaseAlbum,
    BaseButton
  }
})
export default class SingleAlbum extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly image!: string;

  @Prop({ required: true })
  private readonly artists!: ArtistType[];

  @Prop({ required: false, default: false })
  private readonly isPlay!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/album/single-album';
</style>
