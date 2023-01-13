<template>
  <header class="main-header">
    <PlatformLogo />

    <div class="main-header-info">
      <slot />
      <BaseSelect
        class="main-header-language"
        :placeholder="$t('placeholder.choose_lang')"
        :options="selectLanguages"
        :selected-options="[$i18n.locale]"
        @optionSelected="selectLanguage"
      />
    </div>
  </header>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PlatformLogo from '~/components/Business/Logo/PlatformLogo.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import SelectOptionType from '~/types/ui/select/select-option-type';
import ApiRequestService from '~/services/business/api-request-service';
import SelectOptionService from '~/services/ui/Select/select-option-service';
import ListLanguageRequest from '~/api/requests/ListLanguageRequest';

@Component({
  components: {
    PlatformLogo,
    BaseSelect
  },

  async fetch() {
    const that = this as TheMainHeader;
    const requestService = new ApiRequestService(this);
    const listLanguageRequest = new ListLanguageRequest(requestService);

    await listLanguageRequest.request();

    that.selectLanguages = listLanguageRequest.collectToSelect();
  }
})
export default class TheMainHeader extends Vue {
  private selectLanguages: Array<SelectOptionType> = [];

  private selectLanguage(option: SelectOptionService): void {
    this.$i18n.setLocale(option.option.value);
    this.$cookies.set(this.$config.langCookieName, option.option.value);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/header/main-header.scss';
</style>
