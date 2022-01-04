<template>
  <base-album :name="name" :image="image" :authors="authors" :to="to">
    <div class="play-album" @click="$emit('play')">
      <svg-alias alias="play-svg" />
    </div>
  </base-album>
</template>
<script>
import BaseAlbum from "./BaseAlbumComponent";

export default {
  name: "AlbumWithPlayComponent",
  props: {
    /**
     * Album name
     *
     * @type {String}
     */
    name: {
      type: String,
      required: true
    },

    /**
     * Path album image
     *
     * @type {String}
     */
    image: {
      type: String,
      required: true
    },

    /**
     * Array of author objects
     * exp. {id: 1, name: Author}
     *
     * @type {Array}
     */
    authors: {
      type: Array,
      required: true
    },

    /**
     * Link for redirect
     *
     * @type {String || Object}
     */
    to: {
      type: [String, Object],
      required: true
    }
  },
  components: {
    BaseAlbum
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/albumWithPlayButton";
</style>
