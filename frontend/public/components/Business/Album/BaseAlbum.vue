<template>
  <div class="album">
    <a href="">
      <img class="album__image" :src="image" :alt="title" />
      <div class="album__title">{{ title }}</div>
    </a>

    <BaseButton class="album__play-btn">
      <i v-if="!isPlay" class="fas fa-play"></i>
      <i v-else class="fas fa-pause"></i>
    </BaseButton>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '@/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseAlbum extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly image!: string;

  @Prop({ required: false, default: false })
  private readonly isPlay!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/album/base-album';
</style>
