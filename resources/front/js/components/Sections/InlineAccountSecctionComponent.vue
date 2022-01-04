<template>
  <section class="inline-account-section" :class="{ disabled }">
    <div class="inline-account-section__headers">
      <h3
        class="inline-account-section__title"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ title }}
      </h3>
      <p
        v-if="null !== subtitle"
        class="inline-account-section__subtitle"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ subtitle }}
      </p>
    </div>
    <div
      class="inline-account-section-content"
      :class="{ 'skeleton-active': isLoading }"
    >
      <slot />
    </div>
  </section>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "InlineAccountSectionComponent",
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
    subtitle: {
      type: String,
      default: null,
      required: false
    },

    /**
     * @type {String}
     */
    iconAlias: {
      type: String,
      default: null,
      required: false
    },

    /**
     * @type {Boolean}
     */
    disabled: {
      type: Boolean,
      default: false,
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

.inline-account-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 20px;
  border-bottom: 1px solid $light-border;
  margin-bottom: 30px;

  &.disabled {
    pointer-events: none;
    opacity: 0.3;
  }

  &:last-of-type {
    border-bottom: none;
  }

  &__title {
    font-size: 18px;
    font-weight: 500;
    color: $section-color;
    margin-bottom: 15px;

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 250px;
      height: 15px;
      color: transparent;
      border-radius: 10px;
    }
  }

  &__subtitle {
    color: $gray;
    margin-left: 15px;
    font-size: 14px;
    max-width: 650px;
    line-height: 20px;
    border-left: 2px solid #e03e10;
    padding-left: 15px;

    &.skeleton-active {
      background-color: $skeleton-bg;
      width: 500px;
      height: 40px;
      color: transparent;
      border-radius: 10px;
      border: none;
    }
  }

  &-content {
    &.skeleton-active {
      > * {
        opacity: 0;
      }

      background-color: $skeleton-bg;
      width: 150px;
      height: 25px;
      color: transparent;
      border-radius: 10px;
    }
  }
}
</style>
