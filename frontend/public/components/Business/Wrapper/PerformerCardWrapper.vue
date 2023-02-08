<template>
  <div class="performer-wrapper">
    <time class="card__year-creation" :datetime="createdAtDate">
      {{ createdAtDate.getFullYear() }}
    </time>
    <span v-for="(performer, index) in performers" :key="performer.id" class="performer">
      <nuxt-link class="performer__link" :to="`/web-player/artist/${performer.id}`">
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
export default class PerformerCardWrapper extends Vue {
  @Prop({ required: true })
  private readonly cardCreatedAt!: string;

  @Prop({ required: true })
  private readonly performers!: Array<PerformerType>;

  private readonly createdAtDate = new Date(this.cardCreatedAt);
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/wrapper/performer-card-wrapper.scss';
</style>
