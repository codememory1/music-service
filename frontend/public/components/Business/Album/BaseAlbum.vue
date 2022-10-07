<template>
  <div class="album">
    <a href="">
      <img class="album__image" :src="image" :alt="title" />
      <div class="album__title">{{ title }}</div>
      <span class="album-artists">
        <ArtistLink v-for="artist in artists" :key="artist.id" href="/">
          {{ artist.name }}
        </ArtistLink>
      </span>
    </a>

    <slot />
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
export default class BaseAlbum extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly image!: string;

  @Prop({ required: true })
  private readonly artists!: ArtistType[];
}
</script>

<style lang="scss">
@import '@/assets/scss/business/album/base-album';
</style>
