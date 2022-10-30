<template>
  <div class="modal" :class="{ active: isOpenData }">
    <div class="modal__bg" @click="close" />
    <div class="modal-wrapper">
      <div class="modal-top">
        <BaseButton class="modal__close-btn" @click="close">
          <i class="fal fa-times" />
        </BaseButton>
      </div>
      <div class="modal-content">
        <h3 v-if="null !== title" class="modal__title">{{ title }}</h3>

        <slot />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseModal extends Vue {
  @Prop({ required: false, default: null })
  private readonly title!: string;

  @Prop({ required: false, default: false })
  private readonly isOpen!: boolean;

  @Prop({ required: false, default: false })
  private readonly bodyScroll!: boolean;

  private isOpenData: boolean = this.isOpen;

  private closeOurContainer(event: PointerEvent): void {
    const element = this.$refs.modal as Element;
    const target = event.target as Element;

    if (target.contains(element)) {
      this.close();
    }
  }

  @Emit('open')
  public open(): void {
    this.isOpenData = true;

    if (!this.bodyScroll) {
      document.body.style.overflow = 'hidden';
    }
  }

  @Emit('close')
  public close(): void {
    this.isOpenData = false;

    if (!this.bodyScroll) {
      document.body.style.overflow = 'auto';
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/base-modal';
</style>
