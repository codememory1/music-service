<template>
  <div class="album relative" v-hover>
    <a class="album__link" href="">
      <img class="album__image" :src="image" :alt="title" />
    </a>

    <span class="album__title">{{ title }}</span>

    <slot />
  </div>
</template>

<script>
export default {
  name: "BaseAlbum",
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
@import "../../assets/css/components/albums/base-album"
</style>
