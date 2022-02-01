<template>
  <nav class="navigation" role="navigation">
    <div class="navigation-content">
      <base-toolbar-mobile-line
        :style="{
          left: `${numberItemsInPercent * getActiveItemIndex}%`,
          width: `${numberItemsInPercent}%`
        }"
      />

      <!-- Items START -->
      <ul class="navigation-items" role="menubar">
        <base-toolbar-mobile-item
          v-for="(item, index) in items"
          :key="index"
          :alias-icon="item.icon"
          :label="item.label"
          :link="item.link"
          :is-active="index === activeItemIndex"
          :style="{ width: `${numberItemsInPercent}%` }"
          @click="clickByItem(index)"
        />
      </ul>
      <!-- Items START -->
    </div>
  </nav>
</template>

<script>
import { arrayValidator } from "vue-props-validation";
import BaseToolbarMobileLine from "./BaseToolbarMobileLine";
import BaseToolbarMobileItem from "./BaseToolbarMobileItem";

export default {
  name: "BaseToolbarMobile",
  components: {
    BaseToolbarMobileLine,
    BaseToolbarMobileItem
  },
  props: {
    /**
     * Items in view object
     * Example: {
     * 		icon: AliasIcon,
     * 		label: LabelMenu,
     * 		link: string|Object
     * 	}
     */
    items: {
      type: Array,
      required: true,
      validator: arrayValidator({
        type: Object,
        validator: {
          icon: String,
          label: String,
          link: [String, Object]
        }
      })
    },

    /**
     * Index of active item
     */
    activeItemIndex: {
      type: Number,
      default: 1
    }
  },

  data: () => ({
    mutableActiveItemIndex: null,
    numberItemsInPercent: 0
  }),

  created() {
    this.mutableActiveItemIndex = this.activeItemIndex;
    this.numberItemsInPercent = 100 / this.items.length;
  },

  computed: {
    /**
     * @returns {number}
     */
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
@import "../../../scss/components/toolbars/base-toolbar-mobile";
</style>
