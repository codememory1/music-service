<template>
  <div class="mixin-card" @click="$emit('click', $event)">
    <div class="mixin-card-images">
      <img
        v-for="artist in data.artists"
        :key="artist.id"
        class="mixin-card__img"
        :src="artist.image"
        :alt="artist.name"
      />

      <CirclePlayButton class="mixin-card__play-btn" @click.stop="$emit('play', data)" />
    </div>
    <div class="mixin-card-info">
      <h3 class="mixin-card__title">{{ data.title }}</h3>
      <PerformerCardWrapper :card-created-at="data.created_at" :performers="data.performers" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import CirclePlayButton from '~/components/Business/Button/CirclePlayButton.vue';
import MixinCardResponseInterface from '~/interfaces/business/api-responses/mixin-card-response-interface';
import PerformerCardWrapper from '~/components/Business/Wrapper/PerformerCardWrapper.vue';

@Component({
  components: {
    CirclePlayButton,
    PerformerCardWrapper
  }
})
export default class MixinCard extends Vue {
  @Prop({ required: true })
  private readonly data!: MixinCardResponseInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/card/mixin-card.scss';
</style>
