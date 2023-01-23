<template>
  <main>
    <TheArtistProfile
      :name="artistProfileService.getPseudonym"
      :description="artistProfileService.getDescription"
      :background="artistProfileService.getBackgroundLink"
    />
    <div class="wp-container wp-mt">
      <TopAlbumSection :albums="artistProfileService.getTopAlbums" />

      <div class="wp-mt">
        <div class="wp-half-container">
          <TopTrackSection :tracks="artistProfileService.getTopTracks" />
          <SimilarArtistSection :artists="artistProfileService.getSimilarArtists" />
        </div>
      </div>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheArtistProfile from '~/components/Business/Profile/Artist/TheArtistProfile.vue';
import TopAlbumSection from '~/components/Business/Section/TopAlbumSection.vue';
import TopTrackSection from '~/components/Business/Section/TopTrackSection.vue';
import ArtistProfileService from '~/services/business/profile/artist-profile-service';
import SimilarArtistSection from '~/components/Business/Section/SimilarArtistSection.vue';

@Component({
  validate({ params }) {
    return /^\d+$/.test(params.id);
  },

  layout: 'WebPlayerLayout',

  components: {
    TheArtistProfile,
    TopAlbumSection,
    TopTrackSection,
    SimilarArtistSection
  }
})
export default class Artist extends Vue {
  private readonly artistProfileService: ArtistProfileService = new ArtistProfileService(this); // FIX: Сервис использует mock-данные
}
</script>
