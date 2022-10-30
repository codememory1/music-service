<template>
  <div ref="select" class="select">
    <div class="select-top" @click="clickBySelect">
      <BasePlaceholder v-if="activeOptionKeys.length === 0" :placeholder="placeholder" />
      <div v-if="isMultiple" ref="selectedTags" class="select-top-selected-tags">
        <BaseSelectedTag
          v-for="(activeOption, index) in getActiveOptions()"
          ref="selectedTag"
          :key="index"
          :value="getOptionValue(activeOption)"
          @close="deleteElement($event, activeOption)"
        />
      </div>
      <BaseSelectedOption v-else :value="getOptionValue(firstActiveOption)" />
      <div class="select-top__chevron" :class="{ active: isOpen }">
        <i class="far fa-chevron-down"></i>
      </div>
    </div>
    <div class="select-list" :class="{ active: isOpen }">
      <BaseSearch v-if="withSearch" @input="search" />
      <ul class="select-list-items">
        <BaseOption
          v-for="(option, index) in updatedOptions"
          :key="index"
          :value="option.value"
          :is-active="isActiveOption(option)"
          @click="selectElement($event, option)"
        />
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import BaseOption from '~/components/UI/Select/BaseOption.vue';
import BasePlaceholder from '~/components/UI/Select/BasePlaceholder.vue';
import BaseSelectedTag from '~/components/UI/Select/BaseSelectedTag.vue';
import BaseSelectedOption from '~/components/UI/Select/BaseSelectedOption.vue';
import BaseSearch from '~/components/UI/Select/BaseSearch.vue';
import { OptionType } from '~/types/SelectOptionType';
import clickOut from '~/utils/click-out';

@Component({
  components: {
    BaseOption,
    BasePlaceholder,
    BaseSelectedTag,
    BaseSelectedOption,
    BaseSearch
  }
})
export default class BaseSelect extends Vue {
  @Prop({ required: true })
  private readonly placeholder!: string;

  @Prop({ required: true })
  private readonly options!: OptionType[];

  @Prop({ required: false })
  private readonly max!: number;

  @Prop({ required: false, default: () => [] })
  private activeOptions!: Array<string | number>;

  @Prop({ required: false, default: false })
  private readonly isMultiple!: boolean;

  @Prop({ required: false, default: false })
  private readonly isDisabled!: boolean;

  @Prop({ required: false, default: false })
  private readonly withSearch!: boolean;

  private updatedOptions = this.options;
  private activeOptionKeys = this.activeOptions;
  private isOpen: boolean = false;

  private mounted(): void {
    clickOut(this.$refs.select as Node, (is: boolean, event: PointerEvent) => {
      if (is) {
        this.close(event);
      }
    });
  }

  @Emit('open')
  public open(event: PointerEvent): void {
    this.isOpen = true;
  }

  @Emit('close')
  public close(event: PointerEvent): void {
    this.updatedOptions = this.options;
    this.isOpen = false;
  }

  @Emit('selectElement')
  public selectElement(event: PointerEvent, option: OptionType): object {
    if (this.isActiveOption(option)) {
      this.deleteElement(event, option);
    } else if (this.isMultiple && this.activeOptionKeys.length < this.max) {
      this.activeOptionKeys.push(option.key);
    } else {
      this.activeOptionKeys = [option.key];
      this.isOpen = false;
    }

    return {};
  }

  @Emit('deleteElement')
  public deleteElement(event: PointerEvent, option: OptionType): void {
    this.unselectOption(option);
  }

  private clickBySelect(event: PointerEvent): void {
    this.isOpen ? this.close(event) : this.open(event);
  }

  private get firstActiveOption(): OptionType | null {
    const firstActiveKey = this.activeOptionKeys[0];
    let activeOption = null;

    if (firstActiveKey) {
      this.options.forEach((option: OptionType) => {
        if (option.key === firstActiveKey) {
          activeOption = option;
        }
      });
    }

    return activeOption;
  }

  private getActiveOptions(): Array<OptionType> {
    const options: Array<OptionType> = [];

    this.activeOptionKeys.forEach((activeKey) => {
      const activeOption: OptionType | undefined = this.options.find(
        (value: OptionType) => value.key === activeKey
      );

      if (activeOption !== undefined) {
        options.push(activeOption);
      }
    });

    return options;
  }

  private getOptionValue(option: OptionType): string | number | null {
    return option?.value;
  }

  private isActiveOption(option: OptionType): boolean {
    return this.activeOptionKeys.includes(option.key);
  }

  private unselectOption(value: OptionType): void {
    const indexKey = this.activeOptionKeys.indexOf(value.key);

    if (indexKey !== -1) {
      this.activeOptionKeys.splice(indexKey, 1);
    }
  }

  private search(event: InputEvent): void {
    const options: OptionType[] = [];

    this.options.forEach((el: OptionType) => {
      const optionValue = el.value.toString();
      const target = event.target as HTMLInputElement;

      if (optionValue.search(new RegExp('^' + target.value, 'i')) !== -1) {
        options.push(el);
      }
    });

    this.updatedOptions = options;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/select/base-select';
</style>
