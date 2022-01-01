<template>
  <div class="main__content under-header gutter">
    <account-section
      :title="translation('activeSessions')"
      icon-alias="ticket-svg"
    >
      <base-motionless-alert
        :message="translation('recommendedActiveSession')"
        type="info"
      />
      <div class="active-sessions">
        <div class="active-session">
          <div class="active-session__left">
            <svg-alias
              alias="desktop-svg"
              :class="{ 'skeleton-active': isLoading }"
            />
          </div>
          <div class="active-session__right">
            <div class="active-session__right-info">
              <p
                class="active-session__right-top"
                :class="{ 'skeleton-active': isLoading }"
              >
                <span class="active-session__device">Mac</span>
                -
                <span class="active-session__address">
                  Santa Monica, CA, United States
                </span>
              </p>
              <p
                class="active-session__right-down"
                :class="{ 'skeleton-active': isLoading }"
              >
                <span class="active-session__browser">Chrome</span>
                -
                <span class="active-session__activity">May 6 at 7:23 PM</span>
              </p>
            </div>
            <span
              class="active-sessions__delete-btn base-button without-bg"
              :class="{ 'skeleton-active': isLoading }"
              tabindex="-1"
            >
              {{ translation("deleteSession") }}
            </span>
          </div>
        </div>
        <div class="active-session">
          <div class="active-session__left">
            <svg-alias
              alias="smartphone-svg"
              :class="{ 'skeleton-active': isLoading }"
            />
          </div>
          <div class="active-session__right">
            <div class="active-session__right-info">
              <p
                class="active-session__right-top"
                :class="{ 'skeleton-active': isLoading }"
              >
                <span class="active-session__device">Mac</span>
                -
                <span class="active-session__address">
                  Santa Monica, CA, United States
                </span>
              </p>
              <p
                class="active-session__right-down"
                :class="{ 'skeleton-active': isLoading }"
              >
                <span class="active-session__browser">Chrome</span>
                -
                <span class="active-session__activity now">Active now</span>
              </p>
            </div>
            <span
              class="active-sessions__delete-btn base-button without-bg"
              :class="{ 'skeleton-active': isLoading }"
              tabindex="-1"
            >
              {{ translation("deleteSession") }}
            </span>
          </div>
        </div>
      </div>
      <span
        class="active-sessions__delete-btn base-button without-bg delete-all"
        :class="{ 'skeleton-active': isLoading }"
        >{{ translation("deleteAllActiveSessions") }}</span
      >
    </account-section>
    <inline-account-section
      title="Двухфакторная аутентификация"
      subtitle="Дополнительный уровень безопаности, т.е., во время авторизации, на почту будет выслан дополнительный код подверждения."
    >
      <input type="checkbox" class="switch" />
    </inline-account-section>
    <inline-account-section
      title="Удаление сеанса"
      subtitle="Автоматически удалить текущий сеанс, если сеанс не активен:"
    >
      <base-select
        :options="periodsNotActivitySession"
        :selectedOptions="['one_month']"
        placeholder="Период не активности"
      />
    </inline-account-section>
    <inline-account-section title="Изменение пароля">
      <span class="base-button blue">Открыть окно для изменения пароля</span>
    </inline-account-section>
    <div class="security__buttons">
      <loading-button
        class="base-button accent update-security-settings"
        :class="{ 'skeleton-active': isLoading }"
        >{{ translation("btn@updateSecuritySettings") }}</loading-button
      >
    </div>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import AccountSection from "../../components/Sections/AccountSectionComponent";
import BaseMotionlessAlert from "../../components/BaseMotionlessAlertComponent";
import LoadingButton from "../../components/Buttons/LoadingButtonComponent";
import InlineAccountSection from "../../components/Sections/InlineAccountSecctionComponent";
import BaseSelect from "../../components/Select/BaseSelectComponent";

export default {
  name: "SecurityView",
  components: {
    AccountSection,
    BaseMotionlessAlert,
    LoadingButton,
    InlineAccountSection,
    BaseSelect
  },

  data: () => ({
    periodsNotActivitySession: [
      {
        label: "1 неделя",
        value: "one_week"
      },
      {
        label: "1 месяц",
        value: "one_month"
      },
      {
        label: "3 месяца",
        value: "three_month"
      },
      {
        label: "6 месяцев",
        value: "six_month"
      }
    ]
  }),

  created() {
    this.setPageTitle(this.translation("security"));
  },

  mounted() {
    this.$store.commit("loading/setLoading", false);
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation",
      isReceived: "translation/isReceived",
      isLoading: "loading/isLoading"
    })
  },

  methods: {
    ...mapMutations({
      setPageTitle: "account/setPageTitle"
    })
  },

  watch: {
    isReceived: function (value) {
      if (value) {
        this.setPageTitle(this.translation("security"));
      }
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/views/security";
</style>
