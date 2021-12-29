<template>
  <div class="main__content under-header gutter">
    <account-section
      :title="translation('activeSessions')"
      icon-alias="ticket-svg"
    >
      <base-motionless-alert
        message="Рекомендация! Если увидели подозрительный сеанс, удалите его и смените пароль."
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
      </div>
      <span
        class="active-sessions__delete-btn base-button without-bg delete-all"
        :class="{ 'skeleton-active': isLoading }"
        >{{ translation("deleteAllActiveSessions") }}</span
      >
    </account-section>
    <account-section title="Изминение пароля" icon-alias="key-svg">
      <form class="form__change-password">
        <div class="field__wrapper" :class="{ 'skeleton-active': isLoading }">
          <input
            type="password"
            name="old-password"
            class="dark-input"
            placeholder="Старый пароль"
          />
        </div>
        <div class="field__wrapper" :class="{ 'skeleton-active': isLoading }">
          <input
            type="password"
            name="password"
            class="dark-input"
            placeholder="Новый пароль"
          />
        </div>
        <div class="field__wrapper" :class="{ 'skeleton-active': isLoading }">
          <input
            type="password"
            name="old-password"
            class="dark-input"
            placeholder="Подтверждение пароля"
          />
        </div>
      </form>
    </account-section>
    <div class="security__buttons">
      <loading-button
        class="base-button accent"
        :class="{ 'skeleton-active': isLoading }"
        >Update</loading-button
      >
      <loading-button
        class="base-button dark"
        :class="{ 'skeleton-active': isLoading }"
        >Cancel</loading-button
      >
    </div>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import AccountSection from "../../components/Sections/AccountSectionComponent";
import BaseMotionlessAlert from "../../components/BaseMotionlessAlertComponent";
import LoadingButton from "../../components/Buttons/LoadingButtonComponent";

export default {
  name: "SecurityView",
  components: {
    AccountSection,
    BaseMotionlessAlert,
    LoadingButton
  },

  created() {
    this.setPageTitle(this.translation("security"));
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation",
      isReceived: "translation/isReceived",
      isLoading: "loading/isLoading"
    })
  },

  mounted() {
    this.$store.commit("loading/setLoading", false);
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
