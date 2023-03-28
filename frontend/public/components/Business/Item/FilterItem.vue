<template>
  <div class="filter-item" :class="{ disabled: blocked, active: open }">
    <div class="filter-item-visible-part" @click="toggle">
      <span class="filter-item__title" :class="{ disabled: blocked }">{{ title }}</span>

      <transition name="fade">
        <i v-if="blocked" class="filter-item__icon fal fa-lock-alt" />
        <i v-else-if="!open" class="filter-item__icon fal fa-plus" />
        <i v-else class="filter-item__icon fal fa-minus" />
      </transition>
    </div>
    <transition name="fade">
      <div v-show="open" class="filter-item-content">
        <slot />
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class FilterItem extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false, default: false })
  private readonly blocked!: boolean;

  private open: boolean = false;

  private toggle(): void {
    this.open = this.blocked ? false : !this.open;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/item/filter-item.scss';
</style>
