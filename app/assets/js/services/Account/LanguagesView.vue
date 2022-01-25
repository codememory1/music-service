<template></template>
<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  name: "LanguagesView",

  created() {
    this.setPageTitle(
      `${this.translation("language")} & ${this.translation("region")}`
    );
  },

  computed: {
    ...mapGetters({
      translation: "translation/translation",
      isReceived: "translation/isReceived"
    })
  },

  methods: {
    ...mapMutations({
      setPageTitle: "account/setPageTitle"
    })
  },

  watch: {
    isReceived: function (value) {
      if (value) {
        this.setPageTitle(
          `${this.translation("language")} & ${this.translation("region")}`
        );
      }
    }
  }
};
</script>
