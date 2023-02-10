<template>
  <main>
    <FiltersModal ref="filterModal">
      <FilterItem title="Artist">
        <BaseSelect placeholder="Select artist" :options="[]" />
      </FilterItem>
      <FilterItem title="Album">
        <BaseSelect placeholder="Select album" :options="[]" />
      </FilterItem>
    </FiltersModal>
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
            @openFilters="$refs.filterModal.$refs.modal.open()"
          />
          <!-- FIX: Добавить виды сортировок -->
        </template>
      </TracksSection>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import WebPlayerContentTab from '~/components/Business/Tab/WebPlayerContent/WebPlayerContentTab.vue';
import TracksSection from '~/components/Business/Section/TracksSection.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import RepresentationSettingSectionTop from '~/components/Business/Section/Parts/RepresentationSettingSectionTop.vue';
import FiltersModal from '~/components/Business/Modal/FiltersModal.vue';
import FilterItem from '~/components/Business/Item/FilterItem.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import mocks from '~/api/mocks';

@Component({
  layout: 'WebPlayerLayout',
  components: {
    WebPlayerContentTab,
    BaseButton,
    TracksSection,
    RepresentationSettingSectionTop,
    FiltersModal,
    FilterItem,
    BaseSelect
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
}
</script>
