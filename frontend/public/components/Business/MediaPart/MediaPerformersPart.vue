<template>
  <div class="media-part-performers-wrapper">
    <time class="media-part__year-creation" :datetime="createdAtDate">
      {{ createdAtDate.getFullYear() }}
    </time>
    <span
      v-for="(performer, index) in performers"
      :key="performer.id"
      class="media-part__performer"
    >
      <nuxt-link class="media-part__performer-link" :to="`/web-player/artist/${performer.id}`">
        {{ performer.title }}
      </nuxt-link>
      <template v-if="index < performers.length - 1">&</template>
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import PerformerType from '~/types/business/performer-type';

@Component
export default class MediaPerformersPart extends Vue {
  @Prop({ required: true })
  private readonly cardCreatedAt!: string;

  @Prop({ required: true })
  private readonly performers!: Array<PerformerType>;

  private readonly createdAtDate = new Date(this.cardCreatedAt);
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/media-part/media-performers-part.scss';
</style>
