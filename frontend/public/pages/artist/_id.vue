<template>
  <OpenPlayerLayout>
    <template #header>
      <ArtistHeaderSearch />
    </template>
  </OpenPlayerLayout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import OpenPlayerLayout from '~/layouts/OpenPlayerLayout.vue';
import ArtistHeaderSearch from '~/components/Business/Artist/Profile/ArtistProfileHeaderSearch.vue';

@Component({
  validate({ params }) {
    return /^\d+$/.test(params.id);
  },

  components: {
    OpenPlayerLayout,
    ArtistHeaderSearch
  }
})
export default class Artist extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/pages/artist';
</style>
