<template>
  <div class="active-session">
    <div class="active-session__left">
      <svg-alias
        v-if="'computer' === deviceType"
        alias="desktop-svg"
        :class="{ 'skeleton-active': isLoading }"
      />
      <svg-alias
        v-else
        alias="smartphone-svg"
        :class="{ 'skeleton-active': isLoading }"
      />
    </div>

    <!-- Session info START -->
    <div class="active-session__right">
      <div class="active-session__right-info">
        <p
          class="active-session__right-top"
          :class="{ 'skeleton-active': isLoading }"
        >
          <span class="active-session__device">{{ deviceName }}</span>
          -
          <span class="active-session__address">{{ address }}</span>
        </p>
        <p
          class="active-session__right-down"
          :class="{ 'skeleton-active': isLoading }"
        >
          <span class="active-session__browser">{{ browser }}</span>
          -
          <span v-if="isActive" class="active-session__activity now">
            {{ translation("activeNow") }}
          </span>
          <span v-else class="active-session__activity">{{ lastActive }}</span>
        </p>
      </div>
      <!-- Session info END -->

      <!-- Button delete session START -->
      <loading-button
        class="without-bg color__red active-sessions__btn-delete"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ translation("deleteSession") }}
      </loading-button>
      <!-- Button delete session END -->
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import LoadingButton from "../../../components/Buttons/LoadingButtonComponent";

export default {
  name: "ActiveSessionComponent",
  components: {
    LoadingButton
  },

  props: {
    /**
     * @type {String}
     */
    deviceType: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    deviceName: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    browser: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    address: {
      type: String,
      required: true
    },

    /**
     * @type {Boolean}
     */
    isActive: {
      type: Boolean,
      required: true
    },

    /**
     * @type {String}
     */
    lastActive: {
      type: String,
      default: null,
      required: false
    }
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation",
      isLoading: "loading/isLoading"
    })
  }
};
</script>

<style lang="scss">
@import "../../../../scss/components/activeSession";
</style>
