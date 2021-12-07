<template>
  <div
    ref="musicItem"
    class="music-item"
    @contextmenu.prevent="$emit('contextmenu', $event)"
  >
    <div class="music-item__left-info">
      <img class="music-item__image" :src="image" :alt="name" />
      <div class="music-item__names">
        <span class="music-item__name">{{ name }}</span>
        <span class="music-item__author">{{ author }}</span>
      </div>
    </div>
    <div class="music-item__right-info">
      <span class="music-item__time">03:20</span>
      <div class="music-item__buttons">
        <div class="music-item__button">
          <svg-alias class="music-item__button--like" alias="like-svg" />
        </div>
        <div class="music-item__button" @click="$emit('contextmenu', $event, true)">
          <svg-alias
            class="music-item__button--actions"
            alias="vertical-ellipses-svg"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "MusicItem",
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
