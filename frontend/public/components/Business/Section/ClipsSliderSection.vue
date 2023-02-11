<template>
  <BaseSliderCardSection :options="options" :title="title" :cards="clips">
    <template #card="{ item }">
      <BaseClip :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import BaseClip from '~/components/Business/Clip/BaseClip.vue';
import ClipResponseInterface from '~/interfaces/business/api-responses/clip-response-interface';

@Component({
  components: {
    BaseSliderCardSection,
    BaseClip
  }
})
export default class ClipsSliderSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly clips!: Array<ClipResponseInterface>;

  private readonly options = {
    slidesPerView: 4,
    spaceBetween: 15,
    breakpoints: {
      1600: {
        slidesPerView: 6
      }
    }
  };
}
</script>
