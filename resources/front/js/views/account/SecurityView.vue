<template>
  <div class="main__content under-header gutter">
    <account-section :title="translation('activeSessions')">
      <base-motionless-alert
        message="Рекомендация! Если увидели подозрительный сеанс, удалите его и смените пароль."
        type="info"
      />
      <div class="active-sessions">
        <div class="active-session">
          <div class="active-session__left">
            <svg-alias alias="desktop-svg" />
          </div>
          <div class="active-session__right">
            <div class="active-session__right-info">
              <p class="active-session__right-top">
                <span class="active-session__device">Mac</span>
                -
                <span class="active-session__address"
                  >Santa Monica, CA, United States</span
                >
              </p>
              <p class="active-session__right-down">
                <span class="active-session__browser">Chrome</span>
                -
                <span class="active-session__activity">May 6 at 7:23 PM</span>
              </p>
            </div>
            <span
              class="active-sessions__delete-btn base-button without-bg"
              tabindex="-1"
              >{{ translation("deleteSession") }}</span
            >
          </div>
        </div>

        <div class="active-session">
          <div class="active-session__left">
            <svg-alias alias="smartphone-svg" />
          </div>
          <div class="active-session__right">
            <div class="active-session__right-info">
              <p class="active-session__right-top">
                <span class="active-session__device">Mac</span>
                -
                <span class="active-session__address"
                  >Santa Monica, CA, United States</span
                >
              </p>
              <p class="active-session__right-down">
                <span class="active-session__browser">Chrome</span>
                -
                <span class="active-session__activity now">{{
                  translation("activeNow")
                }}</span>
              </p>
            </div>
            <span
              class="active-sessions__delete-btn base-button without-bg"
              tabindex="-1"
              >{{ translation("deleteSession") }}</span
            >
          </div>
        </div>
      </div>
      <span
        class="active-sessions__delete-btn base-button without-bg delete-all"
        >{{ translation("deleteAllActiveSessions") }}</span
      >
    </account-section>
    <account-section title="Изминение пароля" icon-alias="key-svg">
	  
    </account-section>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import AccountSection from "../../components/Sections/AccountSectionComponent";
import BaseMotionlessAlert from "../../components/BaseMotionlessAlertComponent";

export default {
  name: "SecurityView",
  components: {
    AccountSection,
    BaseMotionlessAlert
  },

  created() {
    this.setPageTitle(this.translation("security"));
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation",
      isReceived: "translation/isReceived"
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
