<template>
  <div ref="select" class="select" :class="{ disabled: isDisabled }">
    <BaseSelectBoxCurrent
      :is-active="selectService.isOpened()"
      @click="selectService.toggleIsOpened()"
    >
      <BaseSelectPlaceholder
        v-if="selectService.getOnlySelectedOptions().length === 0"
        :placeholder="placeholder"
      />
      <BaseSelectListSelectedTags
        v-else-if="asMultiple && selectService.getOnlySelectedOptions().length > 0"
      >
        <BaseSelectSelectedTag
          v-for="(optionService, index) in selectService.getOnlySelectedOptions()"
          :key="index"
          :title="optionService.option.title"
          @close="optionService.unselect()"
        />
      </BaseSelectListSelectedTags>
      <BaseSelectSelectedOption v-else :title="selectService.getSelectedOption().option.title" />
    </BaseSelectBoxCurrent>
    <transition name="select-drop-down">
      <div v-show="selectService.isOpened()" class="select-drop-down">
        <BaseSelectSearch v-if="useSearch" @input="selectService.search($event.target.value)" />
        <BaseSelectOptionList ref="selectList">
          <BaseSelectSearchNoMatchesFound v-if="selectService.getOptions().length === 0" />
          <BaseSelectLoading v-if="isLoading" />
          <BaseSelectOption
            v-for="(optionService, index) in selectService.getOptions()"
            v-else
            ref="option"
            :key="index"
            :title="optionService.option.title"
            :is-active="optionService.isSelected()"
            :class="{ active: optionService.isActive() }"
            @click="selectListService.selectOption(optionService, asMultiple)"
          />
        </BaseSelectOptionList>
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Watch, Vue } from 'vue-property-decorator';
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
import SelectOptionService from '~/services/ui/Select/select-option-service';
import SelectService from '~/services/ui/Select/select-service';
import SelectListService from '~/services/ui/Select/select-list-service';
import SelectOptionType from '~/types/ui/select/select-option-type';
import SelectKeydownService from '~/services/ui/Select/select-keydown-service';

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

  private selectService!: SelectService;
  private selectListService!: SelectListService;
  private selectKeydownService!: SelectKeydownService;

  public created(): void {
    this.selectService = new SelectService(this, []);
    this.selectListService = new SelectListService(this.selectService);
    this.selectKeydownService = new SelectKeydownService(
      this.selectService,
      this.selectListService
    );
    this.selectService.setOptions(this.buildOptionsServices());
  }

  public mounted(): void {
    clickOut(this.$refs.select as Node, (is) => {
      if (is) {
        this.selectService.close();
      }
    });

    document.addEventListener('keydown', (event: KeyboardEvent) => {
      this.selectKeydownService.handle(event, this.asMultiple);
    });
  }

  private buildOptionsServices(): Array<SelectOptionService> {
    const options: Array<SelectOptionService> = [];

    this.options.forEach((option) => {
      const optionService = new SelectOptionService(this.selectService, option);

      if (this.selectedOptions.includes(option.value)) {
        optionService.setIsSelected(true);
      }

      options.push(optionService);
    });

    return options;
  }

  @Watch('options')
  private onOptionsChanged(): void {
    this.selectService = new SelectService(this, this.buildOptionsServices());
    this.selectListService = new SelectListService(this.selectService);
    this.selectKeydownService = new SelectKeydownService(
      this.selectService,
      this.selectListService
    );
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/select/base-select.scss';
</style>
