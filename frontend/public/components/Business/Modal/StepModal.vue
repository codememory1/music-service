<template>
  <BaseModal ref="modal" :title="title" class="step-modal">
    <BlockFormElements>
      <BaseProgressStep
        ref="progressSteep"
        :titles="steepTitles"
        :active="stepModalService.getActiveWindow()"
        @changeStep="changeActiveStep"
      />
    </BlockFormElements>
    <BlockFormElements>
      <ModalForm>
        <slot />

        <BaseButton
          v-if="stepModalService.isShowPrevButton()"
          class="only-border"
          @click.prevent="stepModalService.prev()"
        >
          {{ $t('buttons.prev') }}
        </BaseButton>
        <BaseButton
          v-if="stepModalService.isLastWindow()"
          class="accent"
          @click="$emit('sendForm', $event)"
        >
          {{ $t(buttonTitle) }}
        </BaseButton>
        <BaseButton
          v-if="stepModalService.isShowNextButton()"
          class="step-modal__btn-next blue"
          @click.prevent="stepModalService.next()"
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
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import StepModalService from '~/services/ui/modal/step-modal/step-modal-service';

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
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly steepTitles!: Array<string>;

  @Prop({ required: true })
  private readonly buttonTitle!: string;

  private stepModalService!: StepModalService;

  public created(): void {
    this.stepModalService = new StepModalService(this, this.steepTitles);
  }

  private changeActiveStep(index: number): void {
    this.stepModalService.changeTo(index);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/step-modal.scss';
</style>
