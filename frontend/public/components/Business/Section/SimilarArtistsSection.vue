<template>
  <BaseSection>
    <template #header>
      <BaseSectionHeader title="Monthly Top Artists" />
    </template>

    <SimilarArtist v-for="artist in artists" :key="artist.id" :data="artist" />
  </BaseSection>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseSection from '~/components/UI/Section/BaseSection.vue';
import BaseSectionHeader from '~/components/UI/Section/BaseSectionHeader.vue';
import SimilarArtist from '~/components/Business/Artist/SimilarArtist.vue';
import { ArtistType } from '~/types/ArtistType';

@Component({
  components: {
    BaseSection,
    BaseSectionHeader,
    SimilarArtist
  }
})
export default class SimilarArtistsSection extends Vue {
  @Prop({ required: true })
  private readonly artists!: ArtistType[];
}
</script>

<style lang="scss">
@import '@/assets/scss/business/section/similar-artists-section';
</style>
