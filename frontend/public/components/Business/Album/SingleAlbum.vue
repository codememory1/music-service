<template>
  <BaseAlbum :data="data">
    <BaseButton class="album__play-btn">
      <i v-if="!isPlay" class="fas fa-play"></i>
      <i v-else class="fas fa-pause"></i>
    </BaseButton>
  </BaseAlbum>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { AlbumType } from '~/types/AlbumType';

@Component({
  components: {
    BaseAlbum,
    BaseButton
  }
})
export default class SingleAlbum extends Vue {
  @Prop({ required: true })
  private readonly data!: AlbumType;

  @Prop({ required: false, default: false })
  private readonly isPlay!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/album/single-album';
</style>
