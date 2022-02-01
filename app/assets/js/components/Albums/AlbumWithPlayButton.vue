<template>
  <base-album :name="name" :image="image" :authors="authors" :to="to">
    <div class="play-album" @click="$emit('play')">
      <svg-alias alias="play-svg" />
    </div>
  </base-album>
</template>

<script>
import BaseAlbum from "./BaseAlbum";

export default {
  name: "AlbumWithPlayButton",
  components: {
    BaseAlbum
  },
  props: {
    /**
     * Album name
     */
    name: {
      type: String,
      required: true
    },

    /**
     * Path album image
     */
    image: {
      type: String,
      required: true
    },

    /**
     * Array of author objects
     * exp. {id: 1, name: Author}
     */
    authors: {
      type: Array,
      required: true
    },

    /**
     * Link for redirect
     */
    to: {
      type: [String, Object],
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/albums/album-with-play-button";
</style>
