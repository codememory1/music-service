<template>
  <div class="track flex" @contextmenu="$emit('contextmenu', $event)">
    <!--left-->
    <div class="track-img-wrapper">
      <img class="track__image" :src="image" :alt="title" />
    </div>
    <div class="track-names">
      <span class="track__title">{{ title }}</span>
      <base-authors class="track-authors" :authors="authors" />
    </div>

    <!--right-->
    <span class="track__duration-time flex">03:20</span>
    <div class="track-buttons flex">
      <button class="track__button like" role="button">
        <svg-alias alias="like" />
      </button>
      <button class="track__button menu" role="button">
        <svg-alias id="logo" alias="vertical-ellipses" />
      </button>
    </div>
  </div>
</template>

<script>
import BaseAuthors from "@/components/Authors/BaseAuthors";
import { authors } from "@/assets/js/props";

export default {
  name: "BaseTrack",
  components: {
    BaseAuthors
  },

  props: {
    title: {
      type: String,
      required: true
    },

    authors,

    image: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../assets/css/components/tracks/base-track";
</style>
