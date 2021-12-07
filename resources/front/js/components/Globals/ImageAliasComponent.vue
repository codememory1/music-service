<template>
  <img :src="src" :alt="alt" />
</template>
<script>
import ObjectFromArrayByKey from "../../modules/ObjectFromArrayByKey";
import { aliases } from "../../modules/Aliases";

export default {
  name: "ImageAlias",
  props: {
    /**
     * Alias name
     *
     * @type {String}
     */
    alias: {
      type: String,
      required: true
    },

    /**
     * Image alt
     *
     * @type {String}
     */
    alt: {
      type: String,
      default: "",
      required: false
    }
  },

  data: () => ({
    src: null
  }),

  created() {
    const finedObject = ObjectFromArrayByKey(aliases, "name", this.alias);

    this.src = false === finedObject ? "" : finedObject.path;
  }
};
</script>
