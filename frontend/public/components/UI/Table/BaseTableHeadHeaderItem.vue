<template>
  <th v-if="bySort" class="table-head__header-item clickable" @click="$emit('click', uniqueKey)">
    <slot />
  </th>
  <th v-else class="table-head__header-item">
    <slot />
  </th>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseTableHeadHeaderItem extends Vue {
  @Prop({ required: true })
  private readonly uniqueKey!: string;

  @Prop({ required: false, default: false })
  private readonly bySort!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/table/base-table-head-header-item-table.scss';
</style>
