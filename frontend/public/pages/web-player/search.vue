<template>
  <main>
    <div class="wp-container wp-mt-of-header">
      <GenresSection :genres="genres" />
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import GenresSection from '~/components/Business/Section/GenresSection.vue';
import ListGenreResponseType from '~/types/business/api-responses/list-genre-response-type';
import mocks from '~/api/mocks';

@Component({
  layout: 'WebPlayerLayout',
  components: {
    GenresSection
  }
})
export default class Search extends Vue {
  private get genres(): ListGenreResponseType {
    return mocks.top_genres_of_month; // FIX: Исправить на реальный список всех жанров
  }

  public mounted(): void {
    this.$nuxt.$on('search', (event: InputEvent) => {
      // TODO: События при вводе текста в поиск
    });
  }
}
</script>
