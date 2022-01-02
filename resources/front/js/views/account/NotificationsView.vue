<template>
  <div class="main__content under-header gutter">
    <inline-account-section title="Отключить уведомления">
      <base-select
        :options="disableNotificationsOptions"
        :selected-options="notificationStates.disableAllNotifications"
        placeholder="Отключение уведомлений"
      ></base-select>
    </inline-account-section>
    <inline-account-section
      title="Новости"
      subtitle="Уведомить меня о новых новостях платформы Music Service."
    >
      <input type="checkbox" class="switch" v-model="notificationStates.news" />
    </inline-account-section>
    <inline-account-section
      title="Новые релизы"
      subtitle="Уведометить меня о новых релизах у подписываемых авторов."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.newReleases"
      />
    </inline-account-section>
    <inline-account-section
      title="Новые подписчики"
      subtitle="Уведомить меня о новых подписчиках."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.newSubscribes"
      />
    </inline-account-section>
    <inline-account-section
      title="Новые комментарии"
      subtitle="Уведомить меня о новых комментариях."
    >
      <base-select
        :options="newCommentOptions"
        :selected-options="notificationStates.newComments"
        placeholder="Как получать уведомление"
      />
    </inline-account-section>
    <inline-account-section
      title="Вход с других устройств"
      subtitle="Уведометь меня о новых входах в аккаунт с других устройств."
    >
      <input
        type="checkbox"
        class="switch"
        v-model="notificationStates.authFromOtherDevices"
      />
    </inline-account-section>
    <loading-button class="accent">
      Обновить настройки уведомлений
    </loading-button>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import InlineAccountSection from "../../components/Sections/InlineAccountSecctionComponent";
import BaseSelect from "../../components/Select/BaseSelectComponent";
import LoadingButton from "../../components/Buttons/LoadingButtonComponent";

export default {
  name: "NotificationsView",
  components: {
    InlineAccountSection,
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
    isReceived: function (value) {
      if (value) {
        this.setPageTitle(this.translation("notifications"));
      }
    }
  }
};
</script>
