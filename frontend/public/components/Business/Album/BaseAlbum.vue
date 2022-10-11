<template>
  <div class="album">
    <a href="">
      <img class="album__image" :src="data.image" :alt="data.title" />
      <div class="album__title">{{ data.title }}</div>
      <span class="album-artists">
        <ArtistLink v-for="performer in data.performers" :key="performer.id" href="/">
          {{ performer.name }}
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
import { AlbumType } from '~/types/AlbumType';

@Component({
  components: {
    ArtistLink,
    BaseButton
  }
})
export default class BaseAlbum extends Vue {
  @Prop({ required: true })
  private readonly data!: AlbumType;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/album/base-album';
</style>
