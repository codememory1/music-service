<template>
  <div class="data-representation-setting-wrapper">
    <BaseButton class="light-dark section-top__filters-btn" @click="$emit('openFilters')">
      <i class="fal fa-filter" />
      {{ $t('common.filters') }}
    </BaseButton>
    <BaseSelect
      class="section-top__sort-select"
      :placeholder="$t('common.sort_by')"
      :as-multiple="true"
      :options="sorts"
    />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import SelectOptionType from '~/types/ui/select/select-option-type';

@Component({
  components: {
    BaseButton,
    BaseSelect
  }
})
export default class RepresentationSettingSectionTop extends Vue {
  @Prop({ required: true })
  private readonly sorts!: Array<SelectOptionType>;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/parts/representation-setting-section-top.scss';
</style>
