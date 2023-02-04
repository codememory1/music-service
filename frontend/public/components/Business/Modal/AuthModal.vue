<template>
  <BaseModal ref="modal" title="modal.titles.auth">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="changeInputService.inputIsError('email')"
        @input="changeInputService.change($event, 'email')"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_password"
        :is-error="changeInputService.inputIsError('password')"
        @input="changeInputService.change($event, 'password')"
      />
      <BaseButton :is-loading="buttonIsLoading" class="accent" @click.prevent="auth">
        {{ $t('buttons.login') }}
      </BaseButton>

      <p class="via-social-network-text">{{ $t('or_via_social_network') }}</p>

      <div class="auth-from-social-icons">
        <a :href="googleAuthUrl" class="auth-from-social__item">
          <i class="fab fa-google" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-facebook-f" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-twitter" />
        </a>
      </div>

      <ModalSwitcher>
        {{ $t('modal.switch.dont_have_account') }}
        <a @click.prevent="$emit('register')">
          {{ $t('buttons.register') }}
        </a>
      </ModalSwitcher>
      <ModalSwitcher>
        {{ $t('modal.switch.forgot_your_password') }}
        <a @click.prevent="$emit('restorePassword')">
          {{ $t('buttons.restore_password') }}
        </a>
      </ModalSwitcher>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import ModalSwitcher from '~/components/Business/Switch/ModalSwitcher.vue';
import ChangeInputService from '~/services/ui/input/change-input-service';
import InputService from '~/services/ui/input/input-service';
import AuthService from '~/services/business/security/auth-service';
import Routes from '~/api/routes';
import ApiRequestService from '~/services/business/api-request-service';
import GoogleAuthUrlRequest from '~/api/requests/google-auth-url-request';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton,
    ModalSwitcher
  },

  async fetch() {
    const that = this as AuthModal;
    const request = new ApiRequestService(that, that.$i18n.locale);
    const googleAuthUrlRequest = new GoogleAuthUrlRequest(request);

    await googleAuthUrlRequest.request();

    that.googleAuthUrl = googleAuthUrlRequest.getData()?.url || null;
  }
})
export default class AuthModal extends Vue {
  private googleAuthUrl: string | null = null;
  private changeInputService!: ChangeInputService;
  private authService!: AuthService;
  private buttonIsLoading: boolean = false;

  public created(): void {
    this.authService = new AuthService(this);
    this.changeInputService = new ChangeInputService({
      email: new InputService('', 'string', undefined, 1),
      password: new InputService('', 'string', undefined, 1)
    });
  }

  public mounted(): void {
    this.socialNetworkAuth();
  }

  private async socialNetworkAuth(): Promise<void> {
    const query = this.$route.query;

    if ('code' in query && 'state' in query) {
      const modal = this.$refs.modal as BaseModal;

      modal.open();
      modal.setIsLoading(true);

      await this.authService.socialNetworkAuth(
        Routes.social_auth.google.auth,
        query.code as string
      );
    }
  }

  private async auth(): Promise<void> {
    if (this.changeInputService.allFieldsWithoutErrors()) {
      this.buttonIsLoading = true;

      await this.authService.auth({
        email: this.changeInputService.getInput('email').getValue(),
        password: this.changeInputService.getInput('password').getValue()
      });

      this.buttonIsLoading = false;
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/auth-modal.scss';
</style>
