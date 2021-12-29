<template>
  <div class="base-header">
    <!-- Slot to profile block -->
    <slot name="beforeProfile" />

    <!-- Profile START -->
    <div class="base-header__right">
      <div class="base-header__bell" ref="bell">
        <span
          :class="{ 'skeleton-active': isLoading }"
          tabindex="-1"
          class="bell__button"
          @click="openBlockNotifications"
        >
          <svg-alias alias="bell-svg" />
        </span>

        <!-- Block with notifications -->
        <block-notifications :class="{ active: isOpenedBlockNotifications }" />
      </div>
      <div
        class="base-header__user"
        :class="{ 'skeleton-active': isLoading }"
      >
        <img src="/public/images/user.png" alt="profile" />
        <svg-alias alias="arrow-down-svg" />
      </div>
    </div>
    <!-- Profile END -->
  </div>
</template>
<script>
import BlockNotifications from "../../components/Blocks/BlockNotificationsComponent";
import ClickOut from "../../modules/ClickOut";
import { mapGetters } from "vuex";

export default {
  name: "BaseHeader",
  components: {
    BlockNotifications
  },

  data: () => ({
    isOpenedBlockNotifications: false
  }),

  computed: {
    ...mapGetters({
      pageTitle: "account/pageTitle",
      isLoading: "loading/isLoading"
    })
  },

  mounted() {
    ClickOut(this.$refs.bell, (status) => {
      if (status) {
        this.isOpenedBlockNotifications = false;
      }
    });
  },

  methods: {
    openBlockNotifications() {
      this.isOpenedBlockNotifications = !this.isOpenedBlockNotifications;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.base-header {
  width: 100%;
  height: max-content;
  display: flex;
  justify-content: space-between;
  backdrop-filter: saturate(180%) blur(10px);
  background-color: rgba($dark-bg, 0.5);
  position: absolute;
  padding: 20px $gutter;
  z-index: 99;
  align-items: center;

  &__right {
    display: flex;
    align-items: center;
  }

  &__bell {
    margin-right: 20px;
    position: relative;
  }

  &__user {
    display: flex;
    align-items: center;
    cursor: pointer;

    img {
      width: 40px;
      height: 40px;
      border-radius: 100%;
      margin-right: 10px;
      object-fit: cover;
    }

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 40px;
      height: 40px;
      border-radius: 100%;

      img {
        opacity: 0;
      }
    }
  }
}

.bell {
  &__button {
    width: 24px;
    height: 24px;
    position: relative;
    display: flex;
    cursor: pointer;

    svg {
      width: inherit;
      height: inherit;

      ::v-deep path {
        transition: fill 0.2s ease-in-out;
      }

      &:hover {
        ::v-deep path {
          fill: darken(#fff, 40%);
        }
      }
    }

    &:before {
      content: "";
      position: absolute;
      width: 8.5px;
      height: 8.5px;
      background-color: $accent;
      border: 1px solid #fff;
      top: 3.5px;
      right: 0;
      border-radius: 100%;
    }

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 24px;
      height: 24px;
      border-radius: 100%;

      svg {
        opacity: 0;
      }

      &:before {
        opacity: 0;
      }
    }
  }
}

.block-notifications {
  right: -62px;
  top: 45px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(35px);
  transition: visibility 0.2s ease-in-out, opacity 0.2s ease-in-out,
    transform 0.5s ease-in-out;

  &.active {
    visibility: visible;
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
