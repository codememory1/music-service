<template>
  <WebPlayerInformationSection class="clips-section" :title="title">
    <template #top>
      <slot name="top" />
    </template>
    <template #content>
      <EmptyContentSection v-if="clips.length === 0">
        <slot name="empty" />
      </EmptyContentSection>
      <BaseClip v-for="clip in clips" :key="clip.id" :data="clip" />
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import BaseClip from '~/components/Business/Clip/BaseClip.vue';
import EmptyContentSection from '~/components/Business/Section/Parts/EmptyContentSection.vue';
import ClipResponseInterface from '~/interfaces/business/api-responses/clip-response-interface';

@Component({
  components: {
    WebPlayerInformationSection,
    BaseClip,
    EmptyContentSection
  }
})
export default class ClipsSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly clips!: Array<ClipResponseInterface>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/clips-section.scss';
</style>
