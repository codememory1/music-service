<template>
  <inline-svg :src="src" />
</template>

<script>
import ObjectFromArrayByKey from "../../modules/helpers/ObjectFromArrayByKey";
import { aliases } from "../../modules/Aliases";

export default {
  name: "InlineSvgAlias",
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

<style scoped></style>
