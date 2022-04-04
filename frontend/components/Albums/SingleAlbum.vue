<template>
  <base-album
    :title="title"
    :image="image"
    v-hover="{
      exclude_classes: ['single-album__play-button']
    }"
  >
    <button class="single-album__play-button flex flex-x-center flex-y-center">
      <svg-alias alias="play" />
    </button>
  </base-album>
</template>

<script>
import BaseAlbum from "./BaseAlbum";

export default {
  name: "SingleAlbum",
  components: {
    BaseAlbum
  },
  props: {
    title: {
      type: String,
      required: true
    },

    image: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="sass">
@import "../../assets/css/components/albums/single-album"
</style>
