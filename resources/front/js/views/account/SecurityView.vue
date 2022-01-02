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
        <active-session
          v-for="(session, index) in sessions"
          :key="index"
          :device-type="session.device.type"
          :device-name="session.device.name"
          :browser="session.browser"
          :address="session.address"
          :is-active="session.isActive"
          :last-active="session.lastActive"
        />
      </div>
      <loading-button
        class="without-bg color__red active-sessions__btn-delete all"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ translation("deleteAllActiveSessions") }}
      </loading-button>
    </account-section>
    <inline-account-section
      title="Двухфакторная аутентификация"
      subtitle="Дополнительный уровень безопаности, т.е., во время авторизации, на почту будет выслан дополнительный код подверждения."
    >
      <input type="checkbox" class="switch" v-model="twoFactorAuth" />
    </inline-account-section>
    <inline-account-section
      title="Удаление сеанса"
      subtitle="Автоматически удалить текущий сеанс, если сеанс не активен:"
    >
      <base-select
        :options="periodsNotActivitySession"
        :selectedOptions="deleteSession"
        placeholder="Период не активности"
        @change="changePeriodDeleteSession"
      />
    </inline-account-section>
    <inline-account-section title="Изменение пароля">
      <span class="base-button blue">Открыть окно для изменения пароля</span>
    </inline-account-section>
    <div class="security__buttons">
      <loading-button class="base-button accent">
        {{ translation("btn@updateSecuritySettings") }}
      </loading-button>
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
import ActiveSession from "./components/ActiveSessionComponent";

export default {
  name: "SecurityView",
  components: {
    AccountSection,
    BaseMotionlessAlert,
    LoadingButton,
    InlineAccountSection,
    BaseSelect,
    ActiveSession
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
    ],
    sessions: [
      {
        address: "Santa Monica, CA, United States",
        device: {
          type: "computer",
          name: "Macbook Air"
        },
        browser: "Chrome",
        isActive: false,
        lastActive: "May 6 at 7:23 PM"
      },
      {
        address: "Santa Monica, CA, United States",
        device: {
          type: "phone",
          name: "Iphone 11"
        },
        browser: "Chrome",
        isActive: true,
        lastActive: "May 6 at 7:23 PM"
      }
    ],
    twoFactorAuth: false,
    deleteSession: ["one_month"]
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
    }),

    /**
     * @param selected
     */
    changePeriodDeleteSession(selected) {
      this.deleteSession[0] = selected[0];
    }
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
