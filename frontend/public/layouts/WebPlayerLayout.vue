<template>
  <div class="wp-layout">
    <WebPlayerVerticalNavigation />
    <SecurityModalGroup ref="securityModalGroup" />
    <BaseAlertList />

    <div class="wp-main-wrapper">
      <div
        ref="content"
        class="wp-main-page"
        :class="{ 'scroll-allowed': contentScrollingAllowed }"
        @scroll="scrollContent"
      >
        <TheWebPlayerHeader
          :active="headerIsActive"
          @openAuth="$refs.securityModalGroup.openAuthModal()"
        >
          <TheSearchWebPlayerHeader @search="$nuxt.$emit('search', $event)" />
        </TheWebPlayerHeader>

        <div class="wp-main-content">
          <transition name="change-page">
            <Nuxt />
          </transition>
        </div>

        <TheWebPlayerFooter />
      </div>

      <BasePlayer />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import WebPlayerVerticalNavigation from '~/components/Business/Navigation/WebPlayerVerticalNavigation.vue';
import SecurityModalGroup from '~/components/Business/Group/SecurityModalGroup.vue';
import BaseAlertList from '~/components/Business/List/BaseAlertList.vue';
import TheWebPlayerHeader from '~/components/Business/Header/TheWebPlayerHeader.vue';
import TheSearchWebPlayerHeader from '~/components/Business/Header/TheSearchWebPlayerHeader.vue';
import BasePlayer from '~/components/Business/Player/BasePlayer.vue';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';
import TheWebPlayerFooter from '~/components/Business/Footer/TheWebPlayerFooter.vue';

@Component({
  components: {
    WebPlayerVerticalNavigation,
    SecurityModalGroup,
    BaseAlertList,
    TheWebPlayerHeader,
    TheSearchWebPlayerHeader,
    BasePlayer,
    TheWebPlayerFooter
  }
})
export default class WebPlayerLayout extends Vue {
  private readonly authorizedUserService: AuthorizedUserService = new AuthorizedUserService(this);
  private headerIsActive: boolean = false;

  public mounted(): void {
    this.headerIsActive = (this.$refs.content as HTMLElement).scrollTop >= 10;
  }

  private scrollContent(event: Event): void {
    this.headerIsActive = (event.target as HTMLElement).scrollTop >= 40;
  }

  private get contentScrollingAllowed(): boolean {
    return this.$store.getters['modules/global-module/contentScrollingAllowed'];
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/layouts/web-player-layout.scss';
</style>
