<template>
  <div class="artist-profile-header">
    <ArtistHeaderSearch />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import ArtistHeaderSearch from '~/components/Business/Artist/Profile/ArtistProfileHeaderSearch.vue';

@Component({
  components: {
    ArtistHeaderSearch
  }
})
export default class ArtistProfileHeader extends Vue {
  @Prop({ required: true })
  private readonly id!: number;
}
</script>

<style lang="scss"></style>
