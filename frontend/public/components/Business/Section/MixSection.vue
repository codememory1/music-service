<template>
  <BaseSliderCardSection :title="title" :cards="mixes">
    <template #card="{ item }">
      <MixCard :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import MixCardResponseInterface from '~/interfaces/business/api-responses/mix-card-response-interface';
import MixCard from '~/components/Business/Card/MixCard.vue';

@Component({
  components: {
    BaseSliderCardSection,
    MixCard
  }
})
export default class MixSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly mixes!: Array<MixCardResponseInterface>;
}
</script>
