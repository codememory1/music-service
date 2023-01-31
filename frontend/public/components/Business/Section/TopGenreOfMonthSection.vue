<template>
  <BaseSliderCardSection :title="$t('section.titles.top_genres_of_month')" :cards="genres">
    <template #card="{ item }">
      <GenreCard :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import ListGenreResponseType from '~/types/business/api-responses/list-genre-response-type';
import GenreCard from '~/components/Business/Card/GenreCard.vue';

@Component({
  components: {
    BaseSliderCardSection,
    GenreCard
  }
})
export default class TopGenreOfMonthSection extends Vue {
  @Prop({ required: true })
  private readonly genres!: ListGenreResponseType;
}
</script>
