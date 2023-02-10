<template>
  <WebPlayerInformationSection class="tracks-section" :title="title">
    <template #top>
      <slot name="top" />
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
import BaseTrack from '~/components/Business/Track/BaseTrack.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';

@Component({
  components: {
    WebPlayerInformationSection,
    BaseTrack,
    BaseButton,
    BaseSelect
  }
})
export default class TracksSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly tracks!: Array<TrackResponseInterface>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/tracks-section.scss';
</style>
