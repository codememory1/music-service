<template>
  <inline-svg :src="src" />
</template>

<script>
import ObjectFromArrayByKey from "~/assets/js/helpers/object-from-array-by-key";
import { aliases } from "~/assets/js/helpers/aliases";

export default {
  name: "SvgAlias",
  props: {
    /**
     * Alias name
     */
    alias: {
      type: String,
      required: true
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
