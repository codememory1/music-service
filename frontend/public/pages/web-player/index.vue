<template>
  <main ref="main">
    <div class="wp-container">
      <div class="wp-mt-of-header">
        <TopGenreOfMonthSection :genres="topGenresOfMonth" />
        <!--FIX: Изменить топ-жанры за месяц на реальные данные-->
      </div>
      <div class="wp-mt">
        <TrackContextMenu ref="trackContextMenu" />
        <TopTrackSection :tracks="topTracks" see-all-link="" @openContextMenu="openTrackContextMenu" />
        <!--FIX: Подставить ссылку на показ всех топовых треков. Изменить топ треки на реальные данные-->
      </div>
      <div class="wp-mt">
        <TopAlbumSection :albums="topAlbums" />
        <!--FIX: Изменить топ альбомы на реальные данные-->
      </div>
      <div class="wp-mt">
        <TopArtistsOfMonthSection :artists="topArtistsOfMonth" />
        <!--FIX: Изменить топ артисты за месяц на реальные данные-->
      </div>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TopTrackSection from '~/components/Business/Section/TopTrackSection.vue';
import TrackContextMenu from '~/components/Business/ContextMenu/TrackContextMenu.vue';
import TopGenreOfMonthSection from '~/components/Business/Section/TopGenreOfMonthSection.vue';
import TopAlbumSection from '~/components/Business/Section/TopAlbumSection.vue';
import TopArtistsOfMonthSection from '~/components/Business/Section/TopArtistsOfMonthSection.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import mocks from '~/api/mocks';
import ListGenreResponseType from '~/types/business/api-responses/list-genre-response-type';
import ListAlbumResponseType from '~/types/business/api-responses/list-album-response-type';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';
import TrackContextMenuService from '~/services/ui/context-menu/track-context-menu-service';

@Component({
  layout: 'WebPlayerLayout',
  components: {
    TopTrackSection,
    TrackContextMenu,
    TopGenreOfMonthSection,
    TopAlbumSection,
    TopArtistsOfMonthSection
  }
})
export default class Index extends Vue {
  private readonly trackContextMenuService: TrackContextMenuService = new TrackContextMenuService(
    this
  );

  private get topTracks(): Array<TrackResponseInterface> {
    return mocks.artist_1.top_tracks;
  }

  private get topGenresOfMonth(): ListGenreResponseType {
    return mocks.top_genres_of_month;
  }

  private get topAlbums(): ListAlbumResponseType {
    return mocks.artist_1.top_albums;
  }

  private get topArtistsOfMonth(): Array<ArtistCardResponseInterface> {
    return mocks.artist_1.similar_artists;
  }

  private openTrackContextMenu(event: PointerEvent, track: TrackResponseInterface): void {
    this.trackContextMenuService.open(event, track);
  }
}
</script>
