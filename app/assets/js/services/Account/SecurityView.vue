<template>
  <main class="main-content under-header gutter" role="main">
    <!-- Sessions START -->
    <account-section
      :title="translation('activeSessions')"
      icon-alias="ticket-svg"
    >
      <base-alert
        :message="translation('recommendedActiveSession')"
        type="info"
      />

      <!-- Active sessions START -->
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
      <!-- Active sessions END -->

      <!-- Button Delete all active sessions START -->
      <loading-button
        class="bg--transparent color--red active-sessions__btn-delete all"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ translation("deleteAllActiveSessions") }}
      </loading-button>
      <!-- Button Delete all active sessions END -->
    </account-section>
    <!-- Sessions END -->

    <!-- Inline sections START -->
    <base-inline-section
      title="Двухфакторная аутентификация"
      subtitle="Дополнительный уровень безопаности, т.е., во время авторизации, на почту будет выслан дополнительный код подверждения."
    >
      <input type="checkbox" class="switch" v-model="twoFactorAuth" />
    </base-inline-section>
    <base-inline-section
      title="Удаление сеанса"
      subtitle="Автоматически удалить текущий сеанс, если сеанс не активен:"
    >
      <base-select
        :options="periodsNotActivitySession"
        :selectedOptions="deleteSession"
        placeholder="Период не активности"
        @change="changePeriodDeleteSession"
      />
    </base-inline-section>
    <base-inline-section title="Изменение пароля">
      <base-button class="bg--blue">
        Открыть окно для изменения пароля
      </base-button>
    </base-inline-section>
    <!-- Inline sections END -->

    <!-- Update button START -->
    <loading-button class="base-button bg--accent">
      {{ translation("btn@updateSecuritySettings") }}
    </loading-button>
    <!-- Update button END -->
  </main>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import AccountSection from "../../components/Sections/AccountSection";
import BaseAlert from "../../components/Alerts/BaseAlert";
import LoadingButton from "../../components/Buttons/LoadingButton";
import BaseInlineSection from "../../components/Sections/BaseInlineSection";
import ActiveSession from "../Account/components/Security/ActiveSessionComponent";
import BaseSelect from "../../components/Selects/BaseSelect";
import BaseButton from "../../components/Buttons/BaseButton";

export default {
  name: "SecurityViewComponent",
  components: {
    AccountSection,
    BaseAlert,
    LoadingButton,
    BaseInlineSection,
    ActiveSession,
    BaseSelect,
    BaseButton
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
