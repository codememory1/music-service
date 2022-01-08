<template>
  <img :src="src" :alt="alt" />
</template>

<script>
import ObjectFromArrayByKey from "../../modules/helpers/ObjectFromArrayByKey";
import { aliases } from "../../modules/Aliases";

export default {
  name: "ImageAlias",
  props: {
    /**
     * Alias name
     */
    alias: {
      type: String,
      required: true
    },

    /**
     * Image alt
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
