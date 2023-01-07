<template>
  <FieldModalForm>
    <BaseInput
      :type="type"
      :description="description"
      :placeholder="placeholder"
      :is-error="isError"
      class="modal-form__input"
      @input="$emit('input', $event)"
    />
  </FieldModalForm>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';
import BaseInput from '~/components/UI/FormElements/Input/BaseInput.vue';

@Component({
  components: {
    FieldModalForm,
    BaseInput
  }
})
export default class ModalFormInput extends Vue {
  @Prop({ required: false, default: 'text' })
  private readonly type!: string;

  @Prop({ required: true })
  private readonly placeholder!: string;

  @Prop({ required: false, default: undefined })
  private readonly description!: string | undefined;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;
}
</script>
