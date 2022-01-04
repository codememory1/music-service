<template>
  <div
    ref="musicItem"
    class="music-item"
    @contextmenu.prevent="$emit('contextmenu', $event)"
  >
    <!-- Info START -->
    <div class="music-item-left-info">
      <img class="music-item__image" :src="image" :alt="name" />
      <div class="music-item-names">
        <span class="music-item__name">{{ name }}</span>
        <span class="music-item__author">{{ author }}</span>
      </div>
    </div>
    <!-- Info END -->

    <!-- Times info START -->
    <div class="music-item-right-info">
      <span class="music-item__time">03:20</span>

      <!-- Actions START -->
      <div class="music-item-actions">
        <span class="music-item__button" role="button" tabindex="-1">
          <svg-alias class="music-item__button-like" alias="like-svg" />
        </span>
        <span
          class="music-item__button"
          role="button"
          tabindex="-1"
          @click="$emit('contextmenu', $event, true)"
        >
          <svg-alias
            class="music-item__button-action"
            alias="vertical-ellipses-svg"
          />
        </span>
      </div>
      <!-- Actions END -->
    </div>
    <!-- Times info END -->
  </div>
</template>
<script>
export default {
  name: "MusicItemComponent",
  props: {
    /**
     * Music image
     *
     * @type {String}
     */
    image: {
      type: String,
      required: true
    },

    /**
     * Full name of the music
     *
     * @type {String}
     */
    name: {
      type: String,
      required: true
    },

    /**
     * Music author
     *
     * @type {String}
     */
    author: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/components/track";
</style>
