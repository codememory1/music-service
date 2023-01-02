<template>
  <div class="select-selected-tag">
    <span class="select-selected-tag__title">{{ title }}</span>
    <BaseButton class="select-selected-tag__btn-close" @click.prevent="$emit('close')">
      <i class="far fa-times" />
    </BaseButton>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseSelectSelectedTag extends Vue {
  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-selected-tag.scss';
</style>
