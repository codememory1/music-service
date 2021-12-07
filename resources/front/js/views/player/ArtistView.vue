<template>
  <div ref="mainContent" class="main__content">
    <!-- Header START -->
    <div class="artist__header" :style="artistHeaderStyle">
      <div class="relative">
        <h1 class="artist__name">{{ artistInfo.name }}</h1>
        <p class="artist__description">{{ artistInfo.description }}</p>
        <div class="artist__actions">
          <base-custom-click-button
            v-if="artistInfo.isSubscribed"
            class="accent btn-subscription"
          >
            Subscribe
          </base-custom-click-button>
          <base-custom-click-button v-else class="dark btn-subscription">
            Unsubscribe
          </base-custom-click-button>
          <share-button />
        </div>
      </div>
    </div>
    <!-- Header END -->

    <!-- Top albums START -->
    <section-albums sectionTitle="Top Albums" :albums="bestTracks">
      <template v-slot:slider="{ album }">
        <base-album
          :name="album.name"
          :image="album.image"
          :authors="album.authors"
          :to="album.to"
        />
      </template>
    </section-albums>
    <!-- Top albums END -->

    <div class="columns">
      <!-- Top musics START -->
      <base-section title="Top tracks" class="section__top-musics">
        <template v-slot:content>
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
        </template>
      </base-section>
      <!-- Top musics END -->

      <!-- Similar artists START -->
      <base-section title="Similar artists" class="section__similar-artists">
        <template v-slot:content>
          <div class="similar-artists">
            <div
              v-for="(artist, index) in similarArtists"
              :key="index"
              class="similar-artist"
            >
              <router-link :to="{ name: 'artist', params: { id: artist.id } }">
                <img :src="artist.image" :alt="artist.name" />
              </router-link>
            </div>
          </div>

          <!-- Best albums of similar artists START -->
          <base-section
            title="Best albums of similar artists"
            class="best-albums__similar-artists"
          >
            <template v-slot:content>
              <album-with-play
                v-for="(bestAlbum, index) in bestAlbumsSimilarArtists"
                :key="index"
                :name="bestAlbum.name"
                :image="bestAlbum.image"
                :authors="bestAlbum.authors"
                :to="bestAlbum.to"
              />
            </template>
          </base-section>
          <!-- Best albums of similar artists END -->
        </template>
      </base-section>
      <!-- Similar artists END -->
    </div>
    <drop-down
      ref="musicItemDropDown"
      :class="{
        active: isOpenedMusicItemDropDown,
        'music-item__drop-down': true
      }"
      :style="musicItemDropDownStyle()"
    >
      <drop-down-item label="Add to queue" />
      <drop-down-item label="Go to playlist radio" />
      <drop-down-border />
      <drop-down-item label="Collaborative playlist" />
      <drop-down-item label="Remove from profile" />
      <drop-down-border />
      <drop-down-item label="Edit details" />
      <drop-down-item label="Create similar playlist" :is-disabled="true" />
      <drop-down-item label="Delete" />
      <drop-down-item label="Rename" />
      <drop-down-border />
      <drop-down-item label="Download" :is-disabled="true" />
      <drop-down-item label="Create playlist" />
      <drop-down-item label="Create folder" />
      <drop-down-border />
      <drop-down-item label="Share" :is-multiple="true">
        <template v-slot:drop-down>
          <drop-down>
            <drop-down-item label="Facebook" />
            <drop-down-item label="Twitter" />
            <drop-down-item label="Instagram" />
          </drop-down>
        </template>
      </drop-down-item>
    </drop-down>
  </div>
</template>
<script>
import BaseCustomClickButton from "../../components/Buttons/BaseCustomClickButtonComponent";
import ShareButton from "../../components/Buttons/ShareButtonComponent";
import BaseAlbum from "../../components/Albums/BaseAlbumComponent";
import SectionAlbums from "../../components/SectionAlbumsComponent";
import BaseSection from "../../components/Sections/BaseSectionComponent";
import MusicItem from "../../components/MusicItemComponent";
import AlbumWithPlay from "../../components/Albums/AlbumWithPlayComponent";
import DropDown from "../../components/DropDown/DropDownComponent";
import DropDownItem from "../../components/DropDown/DropDownItemComponent";
import DropDownBorder from "../../components/DropDown/DropDownBorderComponent";
import ClickOut from "../../modules/ClickOut";

export default {
  name: "ArtistView",
  components: {
    BaseCustomClickButton,
    ShareButton,
    BaseAlbum,
    SectionAlbums,
    BaseSection,
    MusicItem,
    AlbumWithPlay,
    DropDown,
    DropDownItem,
    DropDownBorder
  },

  data: () => ({
    artistInfo: {
      name: "Zara Larsson",
      description:
        "Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card.",
      background: "/public/images/artist-header.png",
      isSubscribed: false
    },
    bestTracks: [
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image3.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image4.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image5.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image6.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      }
    ],
    similarArtists: [
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist2.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist3.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist4.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist5.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist2.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      }
    ],
    bestAlbumsSimilarArtists: [
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      }
    ],
    isOpenedMusicItemDropDown: false,
    musicItemDropDownX: 0,
    musicItemDropDownY: 0
  }),

  computed: {
    artistHeaderStyle() {
      return {
        backgroundImage: `url(${this.artistInfo.background})`
      };
    }
  },

  mounted() {
    ClickOut(this.$refs.musicItemDropDown.$el, (status) => {
      if (status) {
        this.isOpenedMusicItemDropDown = false;
      }
    });
  },

  methods: {
    musicItemDropDownStyle() {
      return {
        top: `${this.musicItemDropDownY}px`,
        left: `${this.musicItemDropDownX}px`
      };
    },

    musicItemContextMenu: function (event, isButton) {
      /**
       * @type {{x: number, y: number}}
       */
      const playerLayoutPosition = this.$attrs.position;
      const musicItemDropDownRect =
        this.$refs.musicItemDropDown.$el.getBoundingClientRect();
      const dropDownPosition =
        event.clientY - playerLayoutPosition.y + musicItemDropDownRect.height;

      this.isOpenedMusicItemDropDown = false;

      setTimeout(() => {
        this.isOpenedMusicItemDropDown = true;
        this.musicItemDropDownX = event.clientX - playerLayoutPosition.x;

        if (true === isButton) {
          this.musicItemDropDownX -= musicItemDropDownRect.width + 20;
        }

        if (dropDownPosition > window.innerHeight) {
          this.musicItemDropDownY =
            event.clientY -
            playerLayoutPosition.y -
            musicItemDropDownRect.height;
        } else {
          this.musicItemDropDownY = event.clientY - playerLayoutPosition.y;
        }
      }, 300);
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/views/artist";

.music-item__drop-down {
  visibility: hidden;
  opacity: 0;
  transition: visibility 0.3s ease-in-out, opacity 0.4s ease-in-out;

  &.active {
    visibility: visible;
    opacity: 1;
  }
}
</style>
