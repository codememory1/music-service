<template>
  <tr class="table-body__item-wrapper">
    <td v-for="(value, index) in values" :key="index" class="table-body__item-value">
      <slot :name="`name`">
        {{ value }}
      </slot>
    </td>
  </tr>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseTableBodyItem extends Vue {
  @Prop({ required: true })
  private readonly values!: Array<{ [key: string]: string }>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/table/base-table-body-item.scss';
</style>
