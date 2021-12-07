<template>
  <inline-svg :src="src" />
</template>
<script>
import ObjectFromArrayByKey from "../../modules/ObjectFromArrayByKey";
import { aliases } from "../../modules/Aliases";

export default {
  name: "SvgAlias",
  props: {
    /**
     * Alias name
     *
     * @type {String}
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
