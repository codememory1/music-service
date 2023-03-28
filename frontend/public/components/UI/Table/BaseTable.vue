<template>
  <div class="table-wrapper">
    <table class="table">
      <thead class="table-head">
        <tr class="table-head__header">
          <BaseTableHeadHeaderItem
            v-for="header in headers"
            :key="header.key"
            :unique-key="header.key"
          >
            <slot name="header" :label="header.label">
              <slot :name="`header_${header.key}`" :label="header.label">
                {{ header.label }}
              </slot>
            </slot>
          </BaseTableHeadHeaderItem>
        </tr>
      </thead>
      <tbody class="table-body">
        <BaseTableBodyItem v-for="(item, index) in items" :key="index" :data="">
        </BaseTableBodyItem>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseTableHeadHeaderItem from '~/components/UI/Table/BaseTableHeadHeaderItem.vue';
import BaseTableBodyItem from '~/components/UI/Table/BaseTableBodyItem.vue';
import TableHeaderType from '~/types/ui/table/table-header-type';

@Component({
  components: {
    BaseTableHeadHeaderItem,
    BaseTableBodyItem
  }
})
export default class BaseTable extends Vue {
  @Prop({ required: true })
  private readonly headers!: Array<TableHeaderType>;

  @Prop({ required: true })
  private readonly items!: Array<object>;

  private collectedItemData(item: object): object {
    const data = {};

    this.headers.forEach((header) => {
      let value = item;

      if (/\./.test(header.key)) {
        header.key.split('.').forEach((key) => {
          value = value[key] ?? null;
        });
      } else {
        value = (item as any)[header.key];
      }
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/table/base-table.scss';
</style>
