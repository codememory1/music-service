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
        name="new-password"
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
import BaseInput from '~/components/UI/FormElements/Input/BaseInput.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/BasePasswordProgressBar.vue';
import PasswordLevelService from '~/services/ui/password-level-service';

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
  private passwordLevelService!: PasswordLevelService;
  private level!: Array<string>;

  public created(): void {
    this.passwordLevelService = new PasswordLevelService();
    this.level = this.passwordLevelService.levels[0];
  }

  private togglePassword(): void {
    this.isShowPassword = !this.isShowPassword;
  }

  @Emit('input')
  private change(event: InputEvent): void {
    this.level = this.passwordLevelService.defineLevel((event.target as HTMLInputElement).value);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/input/modal-new-password-form-input.scss';
</style>
