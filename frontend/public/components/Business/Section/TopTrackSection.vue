<template>
  <WebPlayerInformationSection class="top-tracks-section see-all" :title="$t('artist.top_tracks')">
    <template #top>
      <nuxt-link class="wp-information-section__see-all-link" to="">
        {{ $t('buttons.see_all') }}
      </nuxt-link>
    </template>
    <template #content>
      <BaseTrack
        v-for="(track, index) in tracks"
        :key="track.id"
        :number="index + 1"
        :data="track"
        @openContextMenu="$emit('openContextMenu', $event, track)"
      />
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import BaseTrack from '~/components/Business/Track/BaseTrack.vue';

@Component({
  components: {
    BaseTrack,
    WebPlayerInformationSection
  }
})
export default class TopTrackSection extends Vue {
  @Prop({ required: true })
  private readonly tracks!: Array<TrackResponseInterface>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/top-track-section.scss';
</style>
