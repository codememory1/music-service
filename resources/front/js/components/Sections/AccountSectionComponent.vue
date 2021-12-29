<template>
  <section class="account-section">
    <div class="account-section__title-wrapper">
      <svg-alias
        v-if="null !== iconAlias"
        :alias="iconAlias"
        :class="{ 'skeleton-active': isLoading }"
      />
      <h3
        class="account-section__title"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ title }}
      </h3>
    </div>

    <slot />
  </section>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  props: {
    /**
     * @type {String}
     */
    title: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    iconAlias: {
      type: String,
      default: null,
      required: false
    }
  },

  computed: {
    ...mapGetters({
      isLoading: "loading/isLoading"
    })
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.account-section {
  margin-bottom: 50px;

  :last-of-type {
    margin-bottom: 0;
  }

  &__title {
    font-size: 18px;
    font-weight: 500;
    color: $section-color;

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 250px;
      height: 15px;
      color: transparent;
      border-radius: 10px;
    }

    &-wrapper {
      display: flex;
      align-items: center;
      padding-bottom: 40px;

      > svg {
        margin-right: 15px;
        width: 24px;
        height: 24px;

        ::v-deep path {
          stroke: $section-color;
        }

        &.skeleton-active {
          background-color: $skeleton-bg;
          border-radius: 100%;

          ::v-deep path {
            opacity: 0;
          }
        }
      }
    }
  }
}
</style>
