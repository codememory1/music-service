<template>
  <div class="mix-card" @click="$emit('click', $event)">
    <div class="mix-card-images">
      <img
        v-for="artist in data.artists"
        :key="artist.id"
        class="mix-card__img"
        :src="artist.image"
        :alt="artist.name"
      />

      <CirclePlayButton class="mix-card__play-btn" @click.stop="$emit('play', data)" />
    </div>
    <div class="mix-card-info">
      <h3 class="mix-card__title">{{ data.title }}</h3>
      <MediaPerformersPart :card-created-at="data.created_at" :performers="data.performers" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import CirclePlayButton from '~/components/Business/Button/CirclePlayButton.vue';
import MixCardResponseInterface from '~/interfaces/business/api-responses/mix-card-response-interface';
import MediaPerformersPart from '~/components/Business/MediaPart/MediaPerformersPart.vue';

@Component({
  components: {
    CirclePlayButton,
    MediaPerformersPart
  }
})
export default class MixCard extends Vue {
  @Prop({ required: true })
  private readonly data!: MixCardResponseInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/card/mix-card.scss';
</style>
