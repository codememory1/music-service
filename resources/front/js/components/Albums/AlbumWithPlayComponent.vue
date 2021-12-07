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
  name: "AlbumWithPlay",
  components: {
    BaseAlbum
  },
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
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.play-album {
  position: absolute;
  background-color: $blue;
  width: 50px;
  height: 50px;
  border-radius: 100%;
  bottom: 60px;
  right: 20px;
  border: 5px solid $dark-bg;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease-in-out;

  &:hover {
    background-color: darken($blue, 10%);
  }

  > svg {
    width: 15px;
    height: 17px;
    position: relative;
    left: 1px;
  }
}
</style>
