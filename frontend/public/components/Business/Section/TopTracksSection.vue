<template>
  <BaseSection class="top-tracks">
    <template #header>
      <BaseSectionHeader title="Billboard Top Charts" />
    </template>

    <BaseTrack v-for="track in tracks" :key="track.id" :data="track" />
  </BaseSection>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseSection from '~/components/UI/Section/BaseSection.vue';
import BaseSectionHeader from '~/components/UI/Section/BaseSectionHeader.vue';
import BaseTrack from '~/components/Business/Track/BaseTrack.vue';
import { TrackType } from '~/types/TrackType';

@Component({
  components: {
    BaseSection,
    BaseSectionHeader,
    BaseTrack
  }
})
export default class TopTracksSection extends Vue {
  @Prop({ required: true })
  private readonly tracks!: TrackType[];
}
</script>

<style lang="scss">
@import '@/assets/scss/business/section/top-tracks-section';
</style>
