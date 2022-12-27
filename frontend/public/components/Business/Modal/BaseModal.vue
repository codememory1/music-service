<template>
  <div class="modal" :class="{ active: syncedIsOpen }">
    <div class="modal__bg" @click="close" />
    <div class="modal-wrapper">
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
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BlockFormElements,
    BaseButton
  }
})
export default class BaseModal extends Vue {
  @Prop({ required: false, default: false })
  private readonly isOpen!: boolean;

  @Prop({ required: true })
  private readonly title!: string;

  private syncedIsOpen: boolean = this.isOpen;

  @Emit('open')
  public open(): void {
    this.syncedIsOpen = true;
  }

  @Emit('close')
  public close(): void {
    this.syncedIsOpen = false;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/base-modal.scss';
</style>
