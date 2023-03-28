<template>
  <TracksSection
    class="see-all"
    :title="$t('section.titles.top_tracks')"
    :tracks="tracks"
    @openContextMenu="openContextMenu"
  >
    <template #top>
      <nuxt-link class="wp-information-section__see-all-link" :to="seeAllLink">
        {{ $t('buttons.see_all') }}
      </nuxt-link>
    </template>
  </TracksSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import BaseTrack from '~/components/Business/Track/BaseTrack.vue';
import TracksSection from '~/components/Business/Section/TracksSection.vue';

@Component({
  components: {
    BaseTrack,
    TracksSection
  }
})
export default class TopTrackSection extends Vue {
  @Prop({ required: true })
  private readonly tracks!: Array<TrackResponseInterface>;

  @Prop({ required: true })
  private readonly seeAllLink!: string;

  private openContextMenu(event: PointerEvent, track: TrackResponseInterface): void {
    this.$emit('openContextMenu', event, track);
  }
}
</script>
