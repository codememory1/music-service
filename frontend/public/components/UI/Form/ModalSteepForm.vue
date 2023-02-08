<template>
  <ModalForm>
    <div class="modal-form-windows-wrapper">
      <div class="modal-form-windows-inner">
        <slot name="windows" />
      </div>
    </div>

    <slot v-if="activeNumber < numberWindows - 1" name="after-windows-if-not-last-window" />
    <slot v-else name="after-windows-if-last-window" />
  </ModalForm>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import ModalForm from '~/components/UI/Form/ModalForm.vue';

@Component({
  components: {
    ModalForm
  }
})
export default class ModalSteepForm extends Vue {
  @Prop({ required: true })
  private readonly numberWindows!: number;

  @Prop({ required: true })
  private readonly activeNumber!: number;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form/modal-steep-form.scss';
</style>
