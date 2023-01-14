<template>
  <main class="index-main">
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
    />
    <RegisterModal
      ref="registerModal"
      @auth="
        $refs.registerModal.$refs.modal.close();
        $refs.authModal.$refs.modal.open();
      "
    />
    <PasswordRecoveryModal
      ref="recoveryPasswordModal"
      @recovery="
        $refs.recoveryPasswordModal.$refs.modal.close();
        $refs.resetPasswordModal.$refs.modal.open();
      "
    />
    <PasswordResetModal ref="resetPasswordModal" />
    <ListInformationSection>
      <div class="home-header-wrapper">
        <div class="container home-header-inner">
          <ListInformationSection>
            <TheMainHeader>
              <TheMainNavigation>
                <MainItemNavigation link="" :title="$t('navigation.main.premium')" />
                <MainItemNavigation link="" :title="$t('navigation.main.support')" />
                <MainItemNavigation
                  :title="$t('navigation.main.signUp')"
                  @click="$refs.registerModal.$refs.modal.open()"
                />
                <MainItemNavigation
                  :title="$t('navigation.main.signIn')"
                  @click="$refs.authModal.$refs.modal.open()"
                />
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
import AuthModal from '~/components/Business/Modal/AuthModal.vue';
import RegisterModal from '~/components/Business/Modal/RegisterModal.vue';
import PasswordRecoveryModal from '~/components/Business/Modal/PasswordRecoveryModal.vue';
import PasswordResetModal from '~/components/Business/Modal/PasswordResetModal.vue';
import TheHomeHero from '~/components/Business/Hero/TheHomeHero.vue';
import ListInformationSection from '~/components/Business/List/ListInformationSection.vue';
import TheMainNavigation from '~/components/Business/Navigation/Main/TheMainNavigation.vue';
import MainItemNavigation from '~/components/Business/Navigation/Main/MainItemNavigation.vue';
import OurAdvantageSection from '~/components/Business/Section/OurAdvantageSection.vue';
import SubscriptionSection from '~/components/Business/Section/SubscriptionSection.vue';
import TheMainFooter from '~/components/Business/Footer/Main/TheMainFooter.vue';

@Component({
  components: {
    TheMainHeader,
    AuthModal,
    RegisterModal,
    PasswordRecoveryModal,
    PasswordResetModal,
    TheHomeHero,
    ListInformationSection,
    TheMainNavigation,
    MainItemNavigation,
    OurAdvantageSection,
    SubscriptionSection,
    TheMainFooter
  }
})
export default class Index extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/pages/index.scss';
</style>
