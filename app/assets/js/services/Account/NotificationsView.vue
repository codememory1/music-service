<template>
  <main class="main-content under-header gutter" role="main">
    <!-- Inline sections START -->
    <base-inline-section title="Отключить уведомления">
      <base-select
        :options="disableNotificationsOptions"
        :selected-options="notificationStates.disableAllNotifications"
        placeholder="Отключение уведомлений"
      ></base-select>
    </base-inline-section>
    <base-inline-section
      title="Новости"
      subtitle="Уведомить меня о новых новостях платформы Music Service."
    >
      <input type="checkbox" class="switch" v-model="notificationStates.news" />
    </base-inline-section>
    <base-inline-section
      title="Новые релизы"
      subtitle="Уведометить меня о новых релизах у подписываемых авторов."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.newReleases"
      />
    </base-inline-section>
    <base-inline-section
      title="Новые подписчики"
      subtitle="Уведомить меня о новых подписчиках."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.newSubscribes"
      />
    </base-inline-section>
    <base-inline-section
      title="Новые комментарии"
      subtitle="Уведомить меня о новых комментариях."
    >
      <base-select
        :options="newCommentOptions"
        :selected-options="notificationStates.newComments"
        placeholder="Как получать уведомление"
      />
    </base-inline-section>
    <base-inline-section
      title="Вход с других устройств"
      subtitle="Уведометь меня о новых входах в аккаунт с других устройств."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.authFromOtherDevices"
      />
    </base-inline-section>
    <!-- Inline sections END -->

    <!-- Update button START -->
    <loading-button class="bg--accent">
      Обновить настройки уведомлений
    </loading-button>
    <!-- Update button END -->
  </main>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import BaseInlineSection from "../../components/Sections/BaseInlineSection";
import BaseSelect from "../../components/Selects/BaseSelect";
import LoadingButton from "../../components/Buttons/LoadingButton";

export default {
  name: "NotificationsView",
  components: {
    BaseInlineSection,
    BaseSelect,
    LoadingButton
  },

  data: () => ({
    disableNotificationsOptions: [
      {
        label: "Выключить уведомления",
        value: "off"
      },
      {
        label: "На 1 час",
        value: "one_hour"
      },
      {
        label: "На 1 день",
        value: "one_day"
      },
      {
        label: "На 7 дней",
        value: "seven_day"
      }
    ],
    newCommentOptions: [
      {
        label: "Отключить",
        value: "off"
      },
      {
        label: "От всех",
        value: "all"
      },
      {
        label: "От подписчиков",
        value: "subscriber"
      }
    ],
    notificationStates: {
      disableAllNotifications: [],
      news: false,
      newReleases: false,
      newSubscribes: false,
      newComments: [],
      authFromOtherDevices: false
    }
  }),

  created() {
    this.setPageTitle(this.translation("security"));
  },

  mounted() {
    this.$store.commit("loading/setLoading", true);
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
    /**
     * Track changes in the status of incoming transfers
     *
     * @param value
     */
    isReceived: function (value) {
      if (value) {
        this.setPageTitle(this.translation("notifications"));
      }
    }
  }
};
</script>
