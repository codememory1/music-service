<template>
  <WebPlayerInformationSection
    class="similar-artists-section"
    :title="$t('artist.similar_artists')"
  >
    <template #content>
      <ArtistCard v-for="artist in artists" :key="artist.id" :data="artist" />
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import ArtistCard from '~/components/Business/Card/ArtistCard.vue';
import SimilarArtistType from '~/types/business/similar-artist-type';

@Component({
  components: {
    WebPlayerInformationSection,
    ArtistCard
  }
})
export default class SimilarArtistSection extends Vue {
  @Prop({ required: true })
  private readonly artists!: Array<SimilarArtistType>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/similar-artist-section.scss';
</style>
