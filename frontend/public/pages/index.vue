<template>
  <main class="index-main">
    <BaseAlertList />
    <AuthModal
      ref="authModal"
      @register="
        $refs.authModal.$refs.modal.close();
        $refs.registerModal.$refs.modal.open();
      "
      @restorePassword="
        $refs.authModal.$refs.modal.close();
        $refs.recoveryPasswordModal.$refs.modal.open();
      "
      @successAuth="$refs.authModal.$refs.modal.close()"
    />
    <RegisterModal
      ref="registerModal"
      @auth="
        $refs.registerModal.$refs.modal.close();
        $refs.authModal.$refs.modal.open();
      "
      @successRegister="successRegister"
    />
    <AccountActivationModal
      ref="accountActivationModal"
      @successActivate="
        $refs.accountActivationModal.$refs.modal.close();
        $refs.authModal.$refs.modal.open();
      "
    />
    <PasswordRecoveryModal
      ref="recoveryPasswordModal"
      @successRecoveryRequest="successPasswordRecoveryRequest"
      @recovery="
        $refs.recoveryPasswordModal.$refs.modal.close();
        $refs.resetPasswordModal.$refs.modal.open();
      "
    />
    <PasswordResetModal
      ref="resetPasswordModal"
      @successPasswordReset="
        $refs.resetPasswordModal.$refs.modal.close();
        $refs.authModal.$refs.modal.open();
      "
    />
    <ListInformationSection>
      <div class="home-header-wrapper">
        <div class="container home-header-inner">
          <ListInformationSection>
            <TheMainHeader>
              <TheMainNavigation>
                <MainItemNavigation link="">{{ $t('navigation.main.premium') }}</MainItemNavigation>
                <MainItemNavigation link="">{{ $t('navigation.main.support') }}</MainItemNavigation>
                <MainItemNavigation
                  v-if="authorizedUserInfo === null"
                  @click="$refs.registerModal.$refs.modal.open()"
                >
                  {{ $t('navigation.main.signUp') }}
                </MainItemNavigation>
                <MainItemNavigation
                  v-if="authorizedUserInfo === null"
                  @click="$refs.authModal.$refs.modal.open()"
                >
                  {{ $t('navigation.main.signIn') }}
                </MainItemNavigation>
                <MainItemNavigation v-if="authorizedUserInfo !== null">
                  <i class="fal fa-user" /> {{ $t('navigation.main.my_account') }}
                  <template #drop-down>
                    <DropDownMainNavigation>
                      <DropDownItemMainNavigation link="">
                        <i class="fal fa-user-cog" /> {{ $t('navigation.main.manage_account') }}
                      </DropDownItemMainNavigation>
                      <DropDownItemMainNavigation link="">
                        <i class="fal fa-mp3-player" /> {{ $t('navigation.main.web_player') }}
                      </DropDownItemMainNavigation>
                      <DropDownItemMainNavigation @click="logout">
                        <i class="fal fa-sign-out" /> {{ $t('navigation.main.logout') }}
                      </DropDownItemMainNavigation>
                    </DropDownMainNavigation>
                  </template>
                </MainItemNavigation>
              </TheMainNavigation>
            </TheMainHeader>
            <TheHomeHero />
          </ListInformationSection>
        </div>
      </div>

      <div class="container">
        <ListInformationSection>
          <OurAdvantageSection />
          <SubscriptionSection />
        </ListInformationSection>
      </div>

      <TheMainFooter />
    </ListInformationSection>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheMainHeader from '~/components/Business/Header/TheMainHeader.vue';
import BaseAlertList from '~/components/Business/List/BaseAlertList.vue';
import AuthModal from '~/components/Business/Modal/AuthModal.vue';
import RegisterModal from '~/components/Business/Modal/RegisterModal.vue';
import AccountActivationModal from '~/components/Business/Modal/AccountActivationModal.vue';
import PasswordRecoveryModal from '~/components/Business/Modal/PasswordRecoveryModal.vue';
import PasswordResetModal from '~/components/Business/Modal/PasswordResetModal.vue';
import TheHomeHero from '~/components/Business/Hero/TheHomeHero.vue';
import ListInformationSection from '~/components/Business/List/ListInformationSection.vue';
import TheMainNavigation from '~/components/Business/Navigation/Main/TheMainNavigation.vue';
import MainItemNavigation from '~/components/Business/Navigation/Main/MainItemNavigation.vue';
import DropDownMainNavigation from '~/components/Business/Navigation/Main/DropDownMainNavigation.vue';
import DropDownItemMainNavigation from '~/components/Business/Navigation/Main/DropDownItemMainNavigation.vue';
import OurAdvantageSection from '~/components/Business/Section/OurAdvantageSection.vue';
import SubscriptionSection from '~/components/Business/Section/SubscriptionSection.vue';
import TheMainFooter from '~/components/Business/Footer/Main/TheMainFooter.vue';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';
import RegisteredUserResponseInterface from '~/interfaces/business/api-responses/registered-user-response-interface';
import PasswordRecoveryResponseInterface from '~/interfaces/business/api-responses/password-recovery-response-interface';

@Component({
  components: {
    TheMainHeader,
    BaseAlertList,
    AuthModal,
    RegisterModal,
    AccountActivationModal,
    PasswordRecoveryModal,
    PasswordResetModal,
    TheHomeHero,
    ListInformationSection,
    TheMainNavigation,
    MainItemNavigation,
    DropDownMainNavigation,
    DropDownItemMainNavigation,
    OurAdvantageSection,
    SubscriptionSection,
    TheMainFooter
  }
})
export default class Index extends Vue {
  private get authorizedUserInfo(): AuthorizedUserInfoResponseInterface | null {
    return this.$store.getters['modules/global-module/authorizedUserInfo'];
  }

  private logout(): void {
    this.$store.commit('modules/global-module/logout', this);
  }

  private successRegister(data: RegisteredUserResponseInterface): void {
    ((this.$refs.registerModal as RegisterModal).$refs as any).modal.close();

    const accountActivationModal = this.$refs.accountActivationModal as AccountActivationModal;

    accountActivationModal.setEmail(data.email);

    (accountActivationModal.$refs as any).modal.open();
  }

  private successPasswordRecoveryRequest(data: PasswordRecoveryResponseInterface): void {
    ((this.$refs.recoveryPasswordModal as PasswordRecoveryModal).$refs as any).modal.close();

    const passwordResetModal = this.$refs.resetPasswordModal as PasswordResetModal;

    passwordResetModal.setEmail(data.user.email);

    (passwordResetModal.$refs as any).modal.open();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/pages/index.scss';
</style>
