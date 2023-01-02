<template>
  <FieldModalForm>
    <BaseTextarea
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
import BaseTextarea from '~/components/UI/Input/BaseTextarea.vue';

@Component({
  components: {
    FieldModalForm,
    BaseTextarea
  }
})
export default class ModalFormTextarea extends Vue {
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
