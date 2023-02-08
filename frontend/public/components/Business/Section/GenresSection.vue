<template>
  <WebPlayerInformationSection class="genres-section" :title="$t('section.titles.all_genres')">
    <template #content>
      <GenreCard
        v-for="genre in genres"
        :key="genre.id"
        :data="genre"
        @click="$emit('click', genre)"
      />
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import GenreCard from '~/components/Business/Card/GenreCard.vue';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import ListGenreResponseType from '~/types/business/api-responses/list-genre-response-type';

@Component({
  components: {
    WebPlayerInformationSection,
    GenreCard
  }
})
export default class GenresSection extends Vue {
  @Prop({ required: true })
  private readonly genres!: ListGenreResponseType;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/genres-section.scss';
</style>
