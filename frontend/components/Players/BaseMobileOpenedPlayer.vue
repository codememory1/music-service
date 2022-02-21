<template>
  <div class="mobile-opened-player">
    <base-mobile-opened-player-head />

    <img :src="image" :alt="title" />

    <div class="mobile-opened-player-track-info">
      <div class="mobile-opened-player-names">
        <span class="mobile-opened-player__title">{{ title }}</span>
        <base-authors class="mobile-opened-player-authors" :authors="authors" />
      </div>

      <button class="opened-mobile-player__like"></button>
    </div>

    <base-mobile-opened-player-time-control />

    <base-mobile-opened-player-control title="" authors="" image="" />
  </div>
</template>

<script>
import BaseAuthors from "@/components/Authors/BaseAuthors";
import BaseMobileOpenedPlayerHead from "./BaseMobileOpenedPlayerHead";
import BaseMobileOpenedPlayerTimeControl from "./BaseMobileOpenedPlayerTimeControl";
import BaseMobileOpenedPlayerControl from "./BaseMobileOpenedPlayerControl";
import { authors } from "@/assets/js/props";

export default {
  name: "BaseMobileOpenedPlayer",
  components: {
    BaseAuthors,
    BaseMobileOpenedPlayerHead,
    BaseMobileOpenedPlayerTimeControl,
    BaseMobileOpenedPlayerControl
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
