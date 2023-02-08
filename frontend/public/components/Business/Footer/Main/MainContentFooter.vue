<template>
  <div class="main-footer-content">
    <PlatformLogo />

    <div class="main-footer-rows">
      <MainRowFooter :title="$t('footer.main.rows.get_started.title')">
        <MainRowItemFooter
          :title="$t('footer.main.rows.get_started.items.pricing_and_plans')"
          link=""
        />
        <MainRowItemFooter :title="$t('footer.main.rows.get_started.items.get_support')" link="" />
      </MainRowFooter>
      <MainRowFooter :title="[$t('footer.main.rows.discover.title'), $config.title].join(' ')">
        <MainRowItemFooter :title="$t('footer.main.rows.discover.items.about')" link="" />
        <MainRowItemFooter :title="$t('footer.main.rows.discover.items.explore_the_app')" link="" />
        <MainRowItemFooter :title="$t('footer.main.rows.discover.items.for_artists')" link="" />
      </MainRowFooter>
      <MainRowFooter :title="$t('footer.main.rows.community.title')">
        <MainRowItemFooter :title="$t('footer.main.rows.community.items.changelog')" link="" />
        <MainRowItemFooter
          :title="[$t('footer.main.rows.community.items.suggestion'), $config.title].join(' ')"
          link=""
        />
        <MainRowItemFooter :title="$t('footer.main.rows.community.items.api')" link="" />
        <MainRowItemFooter
          :title="[$config.title, $t('footer.main.rows.community.items.ads')].join(' ')"
          link=""
        />
      </MainRowFooter>
      <MainRowFooter :title="$t('footer.main.rows.company.title')">
        <MainRowItemFooter :title="$t('footer.main.rows.company.items.partners')" link="" />
        <MainRowItemFooter :title="$t('footer.main.rows.company.items.careers')" link="" />
        <MainRowItemFooter :title="$t('footer.main.rows.company.items.guarantee')" link="" />
        <MainRowItemFooter :title="$t('footer.main.rows.company.items.contacts')" link="" />
      </MainRowFooter>
      <MainRowFooter class="social-media">
        <MainSocialMediaFooter
          :link="getPlatformSettings?.social_media.instagram"
          fa-icon="fab fa-instagram"
        />
        <MainSocialMediaFooter
          :link="getPlatformSettings?.social_media.twitter"
          fa-icon="fab fa-twitter"
        />
        <MainSocialMediaFooter
          :link="getPlatformSettings?.social_media.facebook"
          fa-icon="fab fa-facebook-f"
        />
      </MainRowFooter>
    </div>
    <span class="main-footer__separator" role="separator" />
    <div class="main-footer-bottom">
      <div class="main-footer-copyright">
        <a href="/">
          <img
            class="main-footer-copyright__logo"
            src="/icons/logo-icon.svg"
            :alt="$config.title"
          />
        </a>
        <span class="main-footer-copyright__text">
          © {{ getCurrentYear }} {{ $config.title }} AB
        </span>
      </div>
      <div class="main-footer-bottom-links">
        <a class="main-footer__bottom-link" href="#">
          {{ $t('footer.bottom_links.privacy_policy') }}
        </a>
        <a class="main-footer__bottom-link" href="#">
          {{ $t('footer.bottom_links.terms_and_conditions') }}
        </a>
        <a class="main-footer__bottom-link" href="#">
          {{ $t('footer.bottom_links.cookie_settings') }}
        </a>
        <a class="main-footer__bottom-link" href="https://www.apple.com/ru/sitemap/">
          <!-- FIX: Поменять на свой sitemap -->
          {{ $t('footer.bottom_links.sitemap') }}
        </a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PlatformLogo from '~/components/Business/Logo/PlatformLogo.vue';
import MainRowFooter from '~/components/Business/Footer/Main/MainRowFooter.vue';
import MainRowItemFooter from '~/components/Business/Footer/Main/MainRowItemFooter.vue';
import MainSocialMediaFooter from '~/components/Business/Footer/Main/MainSocialMediaFooter.vue';
import PlatformSettingResponseInterface from '~/interfaces/business/api-responses/platform-setting-response-interface';

@Component({
  components: {
    PlatformLogo,
    MainRowFooter,
    MainRowItemFooter,
    MainSocialMediaFooter
  }
})
export default class MainContentFooter extends Vue {
  private get getPlatformSettings(): PlatformSettingResponseInterface {
    return this.$store.getters['modules/platform-setting-module/settings'];
  }

  private get getCurrentYear(): number {
    return new Date().getFullYear();
  }
}
</script>

<style lang="scss"></style>
