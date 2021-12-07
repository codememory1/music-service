<template>
  <div class="album">
    <router-link class="album__link" :to="to">
      <img class="album__image" :src="image" :alt="name" />
      <span class="album__name">{{ name }}</span>
      <div class="album__authors">
        <router-link
          v-for="(author, index) in authors"
          :key="index"
          :to="{ name: 'artist', params: { id: author.id } }"
        >
          {{ author.name }}
        </router-link>
      </div>
      <slot />
    </router-link>
  </div>
</template>
<script>
export default {
  name: "BaseAlbum",
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
<style lang="scss">
@import "../../../scss/components/album";
</style>
