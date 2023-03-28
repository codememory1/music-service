<template>
  <main>
    <MediaLibraryTrackFiltersModal ref="trackFiltersModal" />
    <MediaLibraryClipFiltersModal ref="clipFiltersModal" />
    <div class="wp-container wp-mt-of-header">
      <WebPlayerContentTab
        v-model="activeTab"
        :tabs="[
          $t('web_player.tab.titles.tracks'),
          $t('web_player.tab.titles.clips'),
          $t('web_player.tab.titles.playlists'),
          $t('web_player.tab.titles.podcasts'),
          $t('web_player.tab.titles.performers'),
          $t('web_player.tab.titles.events')
        ]"
      />
    </div>
    <div v-if="activeTab === TRACKS_TAB_INDEX" class="wp-container wp-mt">
      <TracksSection class="top-jc-sb" :title="$t('section.titles.your_tracks')" :tracks="tracks">
        <template #top>
          <RepresentationSettingSectionTop
            :sorts="[]"
            @openFilters="$refs.trackFiltersModal.open()"
          />
          <!-- FIX: Добавить виды сортировок -->
        </template>
        <template #empty>
          {{ $t('section.empty_content.no_added_tracks') }}
        </template>
      </TracksSection>
    </div>
    <div v-if="activeTab === CLIPS_TAB_INDEX" class="wp-container wp-mt">
      <ClipsSection class="top-jc-sb" :title="$t('section.titles.your_clips')" :clips="clips">
        <template #top>
          <RepresentationSettingSectionTop
            :sorts="[]"
            @openFilters="$refs.clipFiltersModal.open()"
          />
          <!-- FIX: Добавить виды сортировок -->
        </template>
        <template #empty>
          {{ $t('section.empty_content.no_added_clips') }}
        </template>
      </ClipsSection>
    </div>
    <div v-if="activeTab === PERFORMERS_TAB_INDEX" class="wp-container wp-mt">
      <ArtistsSection :title="$t('section.titles.your_favorite_performers')" :artists="performers">
        <template #empty>
          {{ $t('section.empty_content.empty_media_library_no_performers') }}
        </template>
      </ArtistsSection>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import WebPlayerContentTab from '~/components/Business/Tab/WebPlayerContent/WebPlayerContentTab.vue';
import TracksSection from '~/components/Business/Section/TracksSection.vue';
import ClipsSection from '~/components/Business/Section/ClipsSection.vue';
import ArtistsSection from '~/components/Business/Section/ArtistsSection.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import RepresentationSettingSectionTop from '~/components/Business/Section/Parts/RepresentationSettingSectionTop.vue';
import MediaLibraryTrackFiltersModal from '~/components/Business/Modal/Filters/MediaLibraryTrackFiltersModal.vue';
import MediaLibraryClipFiltersModal from '~/components/Business/Modal/Filters/MediaLibraryClipFiltersModal.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import mocks from '~/api/mocks';
import ClipResponseInterface from '~/interfaces/business/api-responses/clip-response-interface';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';

@Component({
  layout: 'WebPlayerLayout',
  components: {
    WebPlayerContentTab,
    BaseButton,
    TracksSection,
    ClipsSection,
    ArtistsSection,
    RepresentationSettingSectionTop,
    MediaLibraryTrackFiltersModal,
    MediaLibraryClipFiltersModal
  }
})
export default class MediaLibrary extends Vue {
  private readonly TRACKS_TAB_INDEX = 0;
  private readonly CLIPS_TAB_INDEX = 1;
  private readonly PLAYLISTS_TAB_INDEX = 2;
  private readonly PODCASTS_TAB_INDEX = 3;
  private readonly PERFORMERS_TAB_INDEX = 4;
  private readonly EVENTS_TAB_INDEX = 5;
  private activeTab: number = this.TRACKS_TAB_INDEX;

  private get tracks(): Array<TrackResponseInterface> {
    return mocks.artist_1.top_tracks; // FIX: Исправить на реальные данные с возвратом треков которые в медиатеке
  }

  private get clips(): Array<ClipResponseInterface> {
    return mocks.artist_1.top_clips; // FIX: Исправить на реальные данные с возвратом клипов которые в медиатеке
  }

  private get performers(): Array<ArtistCardResponseInterface> {
    return mocks.artist_1.similar_artists; // FIX: Исправить на реальные данные с возвратом исполнителей, которые в медиатеке
  }
}
</script>
