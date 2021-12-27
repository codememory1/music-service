<template></template>
<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  name: "NotificationsView",

  created() {
    this.setPageTitle(this.translation("notifications"));
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
        this.setPageTitle(this.translation("notifications"));
      }
    }
  }
};
</script>
