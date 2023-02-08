<template>
  <div class="artist-card">
    <div class="artist-card-img-wrapper">
      <img :src="data.image" :alt="data.name" class="artist-card__img" />
    </div>
    <div class="artist-card-info">
      <h3 class="artist-card__name">{{ data.name }}</h3>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';

@Component
export default class ArtistCard extends Vue {
  @Prop({ required: true })
  private readonly data!: ArtistCardResponseInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/card/artist-card.scss';
</style>
