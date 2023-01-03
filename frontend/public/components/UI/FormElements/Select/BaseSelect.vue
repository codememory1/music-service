<template>
  <div ref="select" class="select" :class="{ disabled: isDisabled }">
    <BaseSelectBoxCurrent :is-active="selectIsOpen" @click="toggleSelect">
      <BaseSelectPlaceholder v-if="syncedSelectedOptions.length === 0" :placeholder="placeholder" />
      <BaseSelectListSelectedTags v-else-if="asMultiple && syncedSelectedOptions.length > 0">
        <BaseSelectSelectedTag
          v-for="(selectedOption, index) in syncedSelectedOptions"
          :key="index"
          :title="getOptionByValue(selectedOption).title"
          @close="unselectOption(selectedOption)"
        />
      </BaseSelectListSelectedTags>
      <BaseSelectSelectedOption v-else :title="getOptionByValue(syncedSelectedOptions[0]).title" />
    </BaseSelectBoxCurrent>
    <transition name="select-drop-down">
      <div v-show="selectIsOpen" class="select-drop-down">
        <BaseSelectSearch v-if="useSearch" ref="search" @input="search" />
        <BaseSelectOptionList ref="selectList">
          <BaseSelectSearchNoMatchesFound v-if="syncedOptions.length === 0" />
          <BaseSelectLoading v-if="isLoading" />
          <BaseSelectOption
            v-for="(option, index) in syncedOptions"
            v-else
            ref="selectOption"
            :key="index"
            :title="option.title"
            :is-active="isSelected(option)"
            :class="{ active: index === activeOptionIndex }"
            @click="selectOption(option)"
          />
        </BaseSelectOptionList>
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { SelectOptionType } from '~/types/SelectOptionType';
import BaseSelectBoxCurrent from '~/components/UI/FormElements/Select/BaseSelectBoxCurrent.vue';
import BaseSelectPlaceholder from '~/components/UI/FormElements/Select/BaseSelectPlaceholder.vue';
import BaseSelectSelectedOption from '~/components/UI/FormElements/Select/BaseSelectSelectedOption.vue';
import BaseSelectListSelectedTags from '~/components/UI/FormElements/Select/BaseSelectListSelectedTags.vue';
import BaseSelectSelectedTag from '~/components/UI/FormElements/Select/BaseSelectSelectedTag.vue';
import BaseSelectSearch from '~/components/UI/FormElements/Select/BaseSelectSearch.vue';
import BaseSelectLoading from '~/components/UI/FormElements/Select/BaseSelectLoading.vue';
import BaseSelectOptionList from '~/components/UI/FormElements/Select/BaseSelectOptionList.vue';
import BaseSelectOption from '~/components/UI/FormElements/Select/BaseSelectOption.vue';
import BaseSelectSearchNoMatchesFound from '~/components/UI/FormElements/Select/BaseSelectSearchNoMatchesFound.vue';
import clickOut from '~/utils/click-out';
import SelectOption from '~/services/Select/SelectOption';

@Component({
  components: {
    BaseSelectBoxCurrent,
    BaseSelectPlaceholder,
    BaseSelectSelectedOption,
    BaseSelectListSelectedTags,
    BaseSelectSelectedTag,
    BaseSelectSearch,
    BaseSelectLoading,
    BaseSelectOptionList,
    BaseSelectOption,
    BaseSelectSearchNoMatchesFound
  }
})
export default class BaseSelect extends Vue {
  @Prop({ required: true })
  private readonly placeholder!: string;

  @Prop({ required: true })
  private readonly options!: Array<SelectOptionType>;

  @Prop({ required: false, default: () => [] })
  private readonly selectedOptions!: Array<string>;

  @Prop({ required: false, default: false })
  private readonly useSearch!: boolean;

  @Prop({ required: false, default: false })
  private readonly isDisabled!: boolean;

  @Prop({ required: false, default: false })
  private readonly asMultiple!: boolean;

  @Prop({ required: false, default: -1 }) // If -1 then unlimited number of selected options
  private readonly maxSelectedOptions!: number; // The prop is used if asMultiple is true

  @Prop({ required: false, default: false })
  private readonly isLoading!: boolean;

  private syncedOptions: Array<SelectOptionType> = this.options;
  private syncedSelectedOptions: Array<string> = this.selectedOptions;
  private selectIsOpen: boolean = false;
  private activeOptionIndex: number = -1;

  private mounted(): void {
    clickOut(this.$refs.select as Node, (is) => {
      if (is) {
        this.close();
      }
    });

    document.addEventListener('keydown', this.keydown);
  }

  private getOptionByValue(value: string): SelectOptionType | undefined {
    return SelectOption.getOptionByValue(value, this.options);
  }

  private isSelected(option: SelectOptionType): boolean {
    return this.syncedSelectedOptions.includes(option.value);
  }

  private toggleSelect(): void {
    if (!this.selectIsOpen) {
      this.open();
    } else {
      this.close();
    }
  }

  private open(): void {
    this.selectIsOpen = true;

    this.$emit('open');
  }

  private close(): void {
    this.selectIsOpen = false;
    this.activeOptionIndex = -1;

    this.$emit('close');
  }

  private selectOption(option: SelectOptionType): void {
    if (this.syncedSelectedOptions.includes(option.value)) {
      this.unselectOption(option.value);
    } else if (!this.asMultiple) {
      this.syncedSelectedOptions = [option.value];

      this.$emit('selectOption', option);

      this.toggleSelect();
    } else {
      this.syncedSelectedOptions.push(option.value);

      this.$emit('selectOption', option);
    }
  }

  private search(event: InputEvent): void {
    this.syncedOptions = SelectOption.searchOptionByTitle(
      (event.target as HTMLInputElement).value,
      this.options
    );
  }

  private keydown(event: KeyboardEvent): void {
    if (this.selectIsOpen) {
      if (event.key === 'ArrowDown') {
        event.preventDefault();

        if (this.activeOptionIndex >= this.syncedOptions.length - 1) {
          this.activeOptionIndex = 0;
        } else {
          this.activeOptionIndex += 1;
        }

        this.scrollList(this.activeOptionIndex);
      } else if (event.key === 'ArrowUp') {
        event.preventDefault();

        if (this.activeOptionIndex <= 0) {
          this.activeOptionIndex = this.syncedOptions.length - 1;
        } else {
          this.activeOptionIndex -= 1;
        }

        this.scrollList(this.activeOptionIndex);
      } else if (event.key === 'Enter' && this.activeOptionIndex !== -1) {
        event.preventDefault();

        this.selectOption(this.syncedOptions[this.activeOptionIndex] as SelectOptionType);
      }
    }
  }

  private scrollList(optionIndex: number): void {
    const option = (this.$refs.selectOption as Array<BaseSelectOption>)[optionIndex];
    const optionElement = option.$el as HTMLElement;

    optionElement.scrollIntoView({ behavior: 'smooth', block: 'end', inline: 'nearest' });
  }

  private unselectOption(value: string): void {
    this.syncedSelectedOptions.splice(this.syncedSelectedOptions.indexOf(value), 1);

    this.selectIsOpen = !this.selectIsOpen;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/select/base-select.scss';
</style>
