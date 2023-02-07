<template>
  <div class="genre-card" :style="styles" @click="$emit('click')">
    <span class="genre-card__title">{{ data.title }}</span>
    <img class="genre-card__img" :src="data.image" :alt="data.title" />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import GenreResponseInterface from '~/interfaces/business/api-responses/genre-response-interface';
import stringToHex from '~/utils/string-to-hex';

@Component
export default class GenreCard extends Vue {
  @Prop({ required: true })
  private readonly data!: GenreResponseInterface;

  private get styles(): object {
    return {
      backgroundColor: stringToHex(this.data.title)
    };
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/card/genre-card.scss';
</style>
