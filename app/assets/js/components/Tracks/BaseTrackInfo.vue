<template>
  <div class="track-info">
    <img class="track-info__image" :src="image" :alt="name" />

    <div class="track-info-names">
      <span class="track-info__name">{{ name }}</span>
      <span class="track-info__author">{{ author }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseTrackInfo",
  props: {
    /**
     * Image track path
     */
    image: {
      type: String,
      required: true
    },

    /**
     * Track name
     */
    name: {
      type: String,
      required: true
    },

    /**
     * Author
     */
    author: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/tracks/base-track-info";
</style>
