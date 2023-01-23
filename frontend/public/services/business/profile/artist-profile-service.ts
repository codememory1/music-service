import { Vue } from 'vue-property-decorator';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import mocks from '~/api/mocks';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import SimilarArtistType from '~/types/business/similar-artist-type';

export default class ArtistProfileService {
  private readonly app: Vue;

  public constructor(app: Vue) {
    this.app = app;
  }

  public get getId(): number {
    return Number(this.app.$route.params.id);
  }

  public get getTopAlbums(): Array<AlbumResponseInterface> {
    return mocks.artist_1.top_albums;
  }

  public get getTopTracks(): Array<TrackResponseInterface> {
    return mocks.artist_1.top_tracks;
  }

  public get getPseudonym(): string {
    return mocks.artist_1.name;
  }

  public get getDescription(): string {
    return mocks.artist_1.description;
  }

  public get getBackgroundLink(): string {
    return mocks.artist_1.background;
  }

  public get getSimilarArtists(): Array<SimilarArtistType> {
    return mocks.artist_1.similar_artists;
  }
}
