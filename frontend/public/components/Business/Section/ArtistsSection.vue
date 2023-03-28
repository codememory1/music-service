<template>
  <WebPlayerInformationSection class="artists-section" :title="title">
    <template #content>
      <EmptyContentSection v-if="artists.length === 0">
        <slot name="empty" />
      </EmptyContentSection>
      <ArtistCard v-for="artist in artists" v-else :key="artist.id" :data="artist" />
    </template>
  </WebPlayerInformationSection>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import WebPlayerInformationSection from '~/components/UI/Section/WebPlayerInformationSection.vue';
import EmptyContentSection from '~/components/Business/Section/Parts/EmptyContentSection.vue';
import ArtistCard from '~/components/Business/Card/ArtistCard.vue';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';

@Component({
  components: {
    WebPlayerInformationSection,
    EmptyContentSection,
    ArtistCard
  }
})
export default class ArtistsSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly artists!: Array<ArtistCardResponseInterface>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/artists-section.scss';
</style>
