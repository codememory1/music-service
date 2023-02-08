<template>
  <BaseSliderCardSection :title="$t('section.titles.top_artists_of_all_time')" :cards="artists">
    <template #card="{ item }">
      <ArtistCard :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import ArtistCard from '~/components/Business/Card/ArtistCard.vue';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';

@Component({
  components: {
    ArtistCard,
    BaseSliderCardSection
  }
})
export default class TopArtistsOfAllTimeSection extends Vue {
  @Prop({ required: true })
  private readonly artists!: Array<ArtistCardResponseInterface>;
}
</script>
