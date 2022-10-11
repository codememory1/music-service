<template>
  <div class="similar-artist">
    <NuxtLink to="/">
      <img :src="data.image" :alt="data.name" />
    </NuxtLink>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { ArtistType } from '~/types/ArtistType';

@Component
export default class SimilarArtist extends Vue {
  @Prop({ required: true })
  private readonly data!: ArtistType;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/artist/similar-artist';
</style>
