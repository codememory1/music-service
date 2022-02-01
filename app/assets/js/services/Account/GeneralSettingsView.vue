<template></template>
<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  name: "GeneralSettingsView",

  created() {
    this.setPageTitle(this.translation("generalSettings"));
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
        this.setPageTitle(this.translation("generalSettings"));
      }
    }
  }
};
</script>
