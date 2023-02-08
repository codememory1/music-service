<template>
  <main>
    <div class="wp-container">
      <div class="wp-mt-of-header">
        <TopArtistsOfAllTimeSection :artists="topArtistsOfAllTime" />
      </div>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TopArtistsOfAllTimeSection from '~/components/Business/Section/TopArtistsOfAllTimeSection.vue';
import ArtistCardResponseInterface from "~/interfaces/business/api-responses/artist-card-response-interface";
import mocks from "~/api/mocks";

@Component({
  layout: 'WebPlayerLayout',
  components: {
    TopArtistsOfAllTimeSection
  }
})
export default class Artists extends Vue {
  private get topArtistsOfAllTime(): Array<ArtistCardResponseInterface> {
    return mocks.artist_1.similar_artists;
  }
}
</script>
