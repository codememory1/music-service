<template>
  <FieldModalForm class="modal-new-password-form-input">
    <PasswordProgressBar :level="level" />

    <div class="relative">
      <i
        v-if="!isShowPassword"
        class="modal-new-password-form-input__btn-toggle-password far fa-eye"
        @click="togglePassword"
      />
      <i
        v-else
        class="modal-new-password-form-input__btn-toggle-password far fa-eye-slash"
        @click="togglePassword"
      />

      <BaseInput
        ref="password"
        :type="isShowPassword ? 'text' : 'password'"
        :description="description"
        :placeholder="placeholder"
        :is-error="isError"
        class="modal-form__input"
        @input="change"
      />
    </div>
  </FieldModalForm>
</template>

<script lang="ts">
import { Component, Emit, Prop, Vue } from 'vue-property-decorator';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';
import BaseInput from '~/components/UI/Input/BaseInput.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/BasePasswordProgressBar.vue';
import passwordComplexityLevel from '~/utils/password-complexity-level';

@Component({
  components: {
    FieldModalForm,
    BaseInput,
    PasswordProgressBar
  }
})
export default class ModalNewPasswordFormInput extends Vue {
  @Prop({ required: true })
  private readonly placeholder!: string;

  @Prop({ required: false, default: undefined })
  private readonly description!: string | undefined;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;

  private isShowPassword: boolean = false;
  private levels: Array<Array<string>> = [
    ['', '', '', '', ''],
    ['first-level', '', '', '', ''],
    ['first-level', 'second-level', '', '', ''],
    ['first-level', 'second-level', 'third-level', '', ''],
    ['first-level', 'second-level', 'third-level', 'fourth-level', ''],
    ['first-level', 'second-level', 'third-level', 'fourth-level', 'fifth-level']
  ];

  private level: Array<string> = this.levels[0];

  private togglePassword(): void {
    this.isShowPassword = !this.isShowPassword;
  }

  @Emit('input')
  private change(event: InputEvent): void {
    const password = (event.target as HTMLInputElement).value;

    if (password.length === 0) {
      this.level = this.levels[0];
    } else {
      const level = passwordComplexityLevel(password);

      if (level === 20) {
        this.level = this.levels[1];
      } else if (level === 40) {
        this.level = this.levels[2];
      } else if (level === 60) {
        this.level = this.levels[3];
      } else if (level === 80) {
        this.level = this.levels[4];
      } else {
        this.level = this.levels[5];
      }
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/input/modal-new-password-form-input.scss';
</style>
