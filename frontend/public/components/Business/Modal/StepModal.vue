<template>
  <BaseModal ref="modal" :title="title" :is-open="isOpen" class="step-modal">
    <BlockFormElements>
      <BaseProgressStep
        ref="progressSteep"
        :titles="steepTitles"
        :active="activeWindow"
        @changeStep="changeStep"
      />
    </BlockFormElements>
    <BlockFormElements>
      <ModalForm>
        <slot />

        <BaseButton v-if="activeWindow > 0" class="only-border" @click.prevent="prev">
          {{ $t('buttons.prev') }}
        </BaseButton>
        <BaseButton
          v-if="activeWindow === steepTitles.length - 1"
          class="accent"
          @click="$emit('sendForm', $event)"
        >
          {{ $t(buttonTitle) }}
        </BaseButton>
        <BaseButton
          v-if="activeWindow < steepTitles.length - 1"
          class="step-modal__btn-next blue"
          @click.prevent="next"
        >
          {{ $t('buttons.next') }}
        </BaseButton>
      </ModalForm>
    </BlockFormElements>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BlockFormElements from '~/components/UI/Block/BlockFormElements.vue';
import BaseProgressStep from '~/components/UI/Step/BaseProgressStep.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseModal,
    BlockFormElements,
    BaseProgressStep,
    BaseButton,
    ModalForm
  }
})
export default class StepModal extends Vue {
  @Prop({ required: false, default: false })
  private readonly isOpen!: boolean;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly steepTitles!: Array<string>;

  @Prop({ required: true })
  private readonly buttonTitle!: string;

  private activeWindow: number = 0;

  private prev(): void {
    this.changeStep(--this.activeWindow);
  }

  private next(): void {
    this.changeStep(++this.activeWindow);
  }

  private changeStep(index: number) {
    this.activeWindow = index;

    this.$emit('changeWindow', this.activeWindow);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/step-modal.scss';
</style>
