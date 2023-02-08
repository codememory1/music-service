<template>
  <BaseSliderCardSection :title="title" :cards="mixes">
    <template #card="{ item }">
      <MixinCard :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import MixCardResponseInterface from '~/interfaces/business/api-responses/mix-card-response-interface';
import MixinCard from '~/components/Business/Card/MixinCard.vue';

@Component({
  components: {
    BaseSliderCardSection,
    MixinCard
  }
})
export default class MixSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly mixes!: Array<MixCardResponseInterface>;
}
</script>
