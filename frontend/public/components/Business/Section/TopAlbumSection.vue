<template>
  <BaseSliderCardSection :title="$t('section.titles.top_albums')" :cards="albums">
    <template #card="{ item }">
      <BaseAlbum :data="item" />
    </template>
  </BaseSliderCardSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import BaseSliderCardSection from '~/components/Business/Section/BaseSliderCardSection.vue';
import BaseAlbum from '~/components/Business/Album/BaseAlbum.vue';

@Component({
  components: {
    BaseSliderCardSection,
    BaseAlbum
  }
})
export default class TopAlbumSection extends Vue {
  @Prop({ required: true })
  private readonly albums!: Array<AlbumResponseInterface>;
}
</script>
