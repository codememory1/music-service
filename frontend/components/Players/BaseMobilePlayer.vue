<template>
  <div class="mobile-player">
    <div class="mobile-player-inner flex">
      <img class="mobile-player__image" :src="image" :alt="title" />

      <!-- Title and authors -->
      <div class="mobile-player-track-info">
        <span class="mobile-player__title">{{ title }}</span>
        <base-authors class="mobile-player-authors" :authors="authors" />
      </div>

      <!-- Control -->
      <base-mobile-player-control />
    </div>
  </div>
</template>

<script>
import BaseAuthors from "@/components/Authors/BaseAuthors";
import BaseMobilePlayerControl from "./BaseMobilePlayerControl";
import { authors } from "@/assets/js/props";

export default {
  name: "BaseMobilePlayer",
  components: {
    BaseAuthors,
    BaseMobilePlayerControl
  },

  props: {
    title: {
      type: String,
      required: true
    },

    image: {
      type: String,
      required: true
    },

    authors
  }
};
</script>
<style lang="scss">
@import "../../assets/css/components/players/base-mobile-player";
</style>
