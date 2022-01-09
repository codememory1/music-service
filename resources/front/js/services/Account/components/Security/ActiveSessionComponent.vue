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
import LoadingButton from "resources/front/js/components/Buttons/LoadingButton.vue";

export default {
  name: "ActiveSessionComponent",
  components: {
    LoadingButton
  },

  props: {
    /**
     * Device type
     */
    deviceType: {
      type: String,
      required: true
    },

    /**
     * Device name
     */
    deviceName: {
      type: String,
      required: true
    },

    /**
     * Browser name
     */
    browser: {
      type: String,
      required: true
    },

    /**
     * Address auth
     */
    address: {
      type: String,
      required: true
    },

    /**
     * Is active now
     */
    isActive: {
      type: Boolean,
      required: true
    },

    /**
     * Last activity
     */
    lastActive: {
      type: String,
      default: null
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
@import "../../../../../scss/views/security/components/activeSession";
</style>
