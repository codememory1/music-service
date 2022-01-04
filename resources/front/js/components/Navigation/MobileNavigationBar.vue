<template>
  <nav class="navigation" role="navigation">
    <div class="navigation-content">
      <span
        class="navigation__border-top"
        :style="{
          left: `${itemWithInPercent * getActiveItemIndex}%`,
          width: `${itemWithInPercent}%`
        }"
      ></span>
      <ul class="navigation-items">
        <li
          class="navigation__item"
          v-for="(item, index) in items"
          :key="index"
          :class="{ active: index === getActiveItemIndex }"
          :style="'width:' + itemWithInPercent + '%'"
          @click="clickByItem(index)"
        >
          <svg-alias :alias="item.iconAlias" />
          <span>{{ item.name }}</span>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
export default {
  name: "MobileNavigationBarComponent",
  props: {
    /**
     * An array of items whose object contains two keys {iconAlias, name}
     *
     * @type {Array}
     */
    items: {
      type: Array,
      required: true
    },

    /**
     * Index of active item
     *
     * @type{Number}
     */
    activeItemIndex: {
      type: Number,
      default: 1,
      required: false
    }
  },

  data: () => ({
    mutableActiveItemIndex: null,
    itemWithInPercent: 0
  }),

  created() {
    this.mutableActiveItemIndex = this.activeItemIndex;
    this.itemWithInPercent = 100 / this.items.length;
  },

  computed: {
    getActiveItemIndex() {
      return this.mutableActiveItemIndex - 1;
    }
  },

  methods: {
    /**
     * Event handler for some navigation element
     *
     * @param index
     */
    clickByItem(index) {
      this.mutableActiveItemIndex = index + 1;

      this.$emit("itemSelection", this.mutableActiveItemIndex);
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/mobileNavigationBar";
</style>
