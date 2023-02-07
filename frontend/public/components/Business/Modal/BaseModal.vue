<template>
  <div class="modal" :class="{ active: isOpen }">
    <div class="modal__bg" @click="close" />
    <div class="modal-wrapper" :class="{ loading: isLoading }">
      <div v-if="isLoading" class="modal-loader">
        <i class="fal fa-spinner-third" />
      </div>

      <BlockFormElements>
        <BaseButton class="modal__btn-close" @click="close">
          <i class="fal fa-times" />
        </BaseButton>
      </BlockFormElements>
      <BlockFormElements>
        <h3 class="modal__title">{{ $t(title) }}</h3>
      </BlockFormElements>

      <slot />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import BlockFormElements from '~/components/UI/Block/BlockFormElements.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BlockFormElements,
    BaseButton
  }
})
export default class BaseModal extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  private isOpen: boolean = false;
  private isLoading: boolean = false;

  @Emit('open')
  public open(): void {
    this.isOpen = true;
  }

  @Emit('close')
  public close(): void {
    this.isOpen = false;
  }

  public setIsLoading(is: boolean): void {
    this.isLoading = is;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/base-modal.scss';
</style>
