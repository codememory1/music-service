<template>
  <main ref="main">
    <TheArtistProfile
      :name="artistProfileService.getPseudonym"
      :description="artistProfileService.getDescription"
      :background="artistProfileService.getBackgroundLink"
    />
    <div class="wp-container wp-mt">
      <TopAlbumSection :albums="artistProfileService.getTopAlbums" />
      <div class="wp-mt">
        <ClipsSliderSection
          :title="$t('section.titles.top_clips')"
          :clips="artistProfileService.getTopClips"
        />
      </div>
      <div class="wp-mt">
        <div class="wp-half-container">
          <TrackContextMenu ref="trackContextMenu" />
          <TopTrackSection
            :tracks="artistProfileService.getTopTracks"
            :see-all-link="`/web-player/artist/${$route.params.id}/tracks/all`"
            @openContextMenu="openTrackContextMenu"
          />
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
import ClipsSliderSection from '~/components/Business/Section/ClipsSliderSection.vue';
import TopTrackSection from '~/components/Business/Section/TopTrackSection.vue';
import ArtistProfileService from '~/services/business/profile/artist-profile-service';
import SimilarArtistSection from '~/components/Business/Section/SimilarArtistSection.vue';
import TrackContextMenu from '~/components/Business/ContextMenu/TrackContextMenu.vue';
import TrackContextMenuService from '~/services/ui/context-menu/track-context-menu-service';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';

@Component({
  validate({ params }) {
    return /^\d+$/.test(params.id);
  },

  layout: 'WebPlayerLayout',

  components: {
    TheArtistProfile,
    TopAlbumSection,
    ClipsSliderSection,
    TopTrackSection,
    SimilarArtistSection,
    TrackContextMenu
  }
})
export default class Artist extends Vue {
  private readonly artistProfileService = Vue.observable(new ArtistProfileService(this));
  private readonly trackContextMenuService = Vue.observable(new TrackContextMenuService(this));

  private openTrackContextMenu(event: PointerEvent, track: TrackResponseInterface): void {
    this.trackContextMenuService.open(event, track);
  }
}
</script>
