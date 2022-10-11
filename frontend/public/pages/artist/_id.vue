<template>
  <OpenPlayerLayout>
    <template #header>
      <ArtistHeaderSearch />
    </template>

    <ArtistProfileHeader
      :id="2"
      pseudonym="Zara Larsson"
      description="Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card."
    />
    <TopAlbumsSection :albums="albums()" />

    <div class="row-grid cl-2 grid-gap-20 m-40">
      <TopTracksSection :tracks="tracks()" />
      <SimilarArtistsSection :artists="similarArtists()" />
    </div>
  </OpenPlayerLayout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import OpenPlayerLayout from '~/layouts/OpenPlayerLayout.vue';
import ArtistHeaderSearch from '~/components/Business/Artist/Profile/ArtistProfileHeaderSearch.vue';
import ArtistProfileHeader from '~/components/Business/Artist/Profile/ArtistProfileHeader.vue';
import TopAlbumsSection from '~/components/Business/Section/TopAlbumsSection.vue';
import TopTracksSection from '~/components/Business/Section/TopTracksSection.vue';
import SimilarArtistsSection from '~/components/Business/Section/SimilarArtistsSection.vue';
import { AlbumType } from '~/types/AlbumType';
import { TrackType } from '~/types/TrackType';
import { ArtistType } from '~/types/ArtistType';

@Component({
  validate({ params }) {
    return /^\d+$/.test(params.id);
  },

  components: {
    OpenPlayerLayout,
    ArtistHeaderSearch,
    ArtistProfileHeader,
    TopAlbumsSection,
    TopTracksSection,
    SimilarArtistsSection
  }
})
export default class Artist extends Vue {
  private albums(): AlbumType[] {
    return [
      {
        id: 1,
        title: 'Album Name',
        image: '/images/album1.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ]
      },
      {
        id: 2,
        title: 'Album Name',
        image: '/images/album2.png',
        performers: [
          {
            id: 1,
            image: '/images/album3.png',
            name: 'Tvbuu'
          }
        ]
      },
      {
        id: 3,
        title: 'Album Name',
        image: '/images/album3.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ]
      },
      {
        id: 4,
        title: 'Album Name',
        image: '/images/album4.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ]
      },
      {
        id: 5,
        title: 'Album Name',
        image: '/images/album5.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ]
      },
      {
        id: 6,
        title: 'Album Name',
        image: '/images/album2.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ]
      }
    ];
  }

  private tracks(): TrackType[] {
    return [
      {
        id: 1,
        title: 'Music Name',
        image: '/images/track1.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ],
        duration: '02:39'
      },
      {
        id: 2,
        title: 'Music Name',
        image: '/images/track2.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ],
        duration: '02:39'
      },
      {
        id: 3,
        title: 'Music Name',
        image: '/images/track3.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ],
        duration: '02:39'
      },
      {
        id: 3,
        title: 'Music Name',
        image: '/images/track4.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ],
        duration: '02:39'
      },
      {
        id: 3,
        title: 'Music Name',
        image: '/images/track2.png',
        performers: [
          {
            id: 1,
            image: '/images/album1.png',
            name: 'Tvbuu'
          }
        ],
        duration: '02:39'
      }
    ];
  }

  private similarArtists(): ArtistType[] {
    return [
      {
        id: 1,
        name: 'Tvbuu',
        image: '/images/artist1.png'
      },
      {
        id: 2,
        name: 'Tvbuu',
        image: '/images/artist2.png'
      },
      {
        id: 3,
        name: 'Tvbuu',
        image: '/images/artist3.png'
      },
      {
        id: 4,
        name: 'Tvbuu',
        image: '/images/artist4.png'
      },
      {
        id: 5,
        name: 'Tvbuu',
        image: '/images/artist1.png'
      },
      {
        id: 6,
        name: 'Tvbuu',
        image: '/images/artist3.png'
      }
    ];
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/pages/artist';
</style>
