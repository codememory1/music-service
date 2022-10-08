<template>
  <div class="similar-artists">
    <div class="similar-artist">
      <NuxtLink to="/">
        <img :src="image" :alt="name" />
      </NuxtLink>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class SimilarArtist extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly name!: string;

  @Prop({ required: true })
  private readonly image!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/artist/similar-artist';
</style>
