<template>
  <main class="index-main">
    <BaseAlertList />
    <SecurityModalGroup ref="securityModalGroup" />

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
                  @click="$refs.securityModalGroup.openRegisterModal()"
                >
                  {{ $t('navigation.main.signUp') }}
                </MainItemNavigation>
                <MainItemNavigation
                  v-if="authorizedUserInfo === null"
                  @click="$refs.securityModalGroup.openAuthModal()"
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
                      <DropDownItemMainNavigation @click="authorizedUserService.logout()">
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
import SecurityModalGroup from '~/components/Business/Group/SecurityModalGroup.vue';
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
import AuthorizedUserService from '~/services/business/user/authorized-user-service';

@Component({
  components: {
    TheMainHeader,
    BaseAlertList,
    SecurityModalGroup,
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
  private readonly authorizedUserService: AuthorizedUserService = new AuthorizedUserService(this);

  private get authorizedUserInfo(): AuthorizedUserInfoResponseInterface | null {
    return this.authorizedUserService.getAuthorizedUser();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/pages/index.scss';
</style>
