<template>
  <div class="active-session">
    <!-- Icon START -->
    <svg-alias
      v-if="'computer' === deviceType"
      alias="desktop-svg"
      class="active-session__icon"
      :class="{ 'skeleton-active': isLoading }"
    />
    <svg-alias
      v-else
      alias="smartphone-svg"
      class="active-session__icon"
      :class="{ 'skeleton-active': isLoading }"
    />
    <!-- Icon END -->

    <!-- Content START -->
    <div class="active-session-content">
      <!-- Info START -->
      <div class="active-session-info">
        <!-- Device and address START -->
        <p
          class="active-session-info__device-address"
          :class="{ 'skeleton-active': isLoading }"
        >
          <span class="active-session__device">{{ deviceName }}</span>
          -
          <span class="active-session__address">{{ address }}</span>
        </p>
        <!-- Device and address END -->

        <!-- Browser and last activity START -->
        <p
          class="active-session-info__browser-last-activity"
          :class="{ 'skeleton-active': isLoading }"
        >
          <span class="active-session__browser">{{ browser }}</span>
          -
          <span v-if="isActive" class="active-session__activity now">
            {{ translation("activeNow") }}
          </span>
          <span v-else class="active-session__activity">{{ lastActive }}</span>
        </p>
        <!-- Browser and last activity END -->
      </div>
      <!-- Info END -->

      <!-- Button delete session START -->
      <loading-button
        class="bg--transparent color--red active-sessions__btn-delete"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ translation("deleteSession") }}
      </loading-button>
      <!-- Button delete session END -->
    </div>
    <!-- Content END -->
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
