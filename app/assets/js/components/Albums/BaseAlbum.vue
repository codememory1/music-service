<template>
  <router-link class="album" :to="to">
    <!-- Info START -->
    <img class="album__image" :src="image" :alt="name" />
    <span class="album__name">{{ name }}</span>
    <!-- Info START -->

    <!-- Authors START -->
    <div class="album-authors">
      <router-link
        v-for="(author, index) in authors"
        :key="index"
        :to="{ name: 'artist', params: { id: author.id } }"
      >
        {{ author.name }}
      </router-link>
    </div>
    <!-- Authors START -->

    <slot />
  </router-link>
</template>

<script>
export default {
  name: "BaseAlbum",
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
@import "../../../scss/components/albums/base-album";
</style>
