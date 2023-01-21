<template>
  <main>
    <TheArtistProfile
      name="Zara Larsson"
      background="/images/artist-header-bg.jpeg"
      description="Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card."
    />
    <div class="wp-container wp-mt">
      <TopAlbumSection
        :albums="[
          {
            id: 1,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          },
          {
            id: 2,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          },
          {
            id: 3,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          },
          {
            id: 4,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          },
          {
            id: 5,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          },
          {
            id: 6,
            title: 'Top album',
            performers: [{ id: 1, title: 'Tvbuu' }],
            created_at: '2023',
            image: '/images/album2.jpeg'
          }
        ]"
      />
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheArtistProfile from '~/components/Business/Profile/Artist/TheArtistProfile.vue';
import TopAlbumSection from '~/components/Business/Section/TopAlbumSection.vue';

@Component({
  validate({ params }) {
    return /^\d+$/.test(params.id);
  },

  layout: 'WebPlayerLayout',

  components: {
    TheArtistProfile,
    TopAlbumSection
  }
})
export default class Artist extends Vue {}
</script>

<style lang="scss"></style>
