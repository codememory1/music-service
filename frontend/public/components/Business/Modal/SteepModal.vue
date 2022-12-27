<template>
  <BaseModal ref="modal" :title="title" :is-open="isOpen">
    <BlockFormElements>
      <BaseHorizontalProgressSteep
        ref="progressSteep"
        :titles="steepTitles"
        :active="activeWindow"
      />
    </BlockFormElements>
    <BlockFormElements>
      <ModalSteepForm :number-windows="steepTitles.length" :active-number="activeWindow">
        <template #windows>
          <slot />
        </template>
        <template #after-windows-if-last-window>
          <BaseButton v-if="activeWindow > 0" class="only-border" @click.prevent="prev">
            {{ $t('buttons.prev') }}
          </BaseButton>
          <BaseButton class="accent" @click="$emit('sendForm', $event)">
            {{ $t(buttonTitle) }}
          </BaseButton>
        </template>
        <template #after-windows-if-not-last-window>
          <BaseButton v-if="activeWindow > 0" class="only-border" @click.prevent="prev">
            {{ $t('buttons.prev') }}
          </BaseButton>
          <BaseButton style="width: 100%;" class="blue" @click.prevent="next">{{ $t('buttons.next') }}</BaseButton>
        </template>
      </ModalSteepForm>
    </BlockFormElements>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BlockFormElements from '~/components/UI/Block/BlockFormElements.vue';
import BaseHorizontalProgressSteep from '~/components/UI/Steep/BaseHorizontalProgressSteep.vue';
import ModalSteepForm from '~/components/UI/Form/ModalSteepForm.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseModal,
    BlockFormElements,
    BaseHorizontalProgressSteep,
    ModalSteepForm,
    BaseButton
  }
})
export default class SteepModal extends Vue {
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
    this.activeWindow -= 1;
  }

  private next(): void {
    this.activeWindow += 1;
  }
}
</script>
