import { Vue } from 'vue-property-decorator';
import AlbumResponseInterface from '~/interfaces/business/api-responses/album-response-interface';
import mocks from '~/api/mocks';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';
import ClipResponseInterface from '~/interfaces/business/api-responses/clip-response-interface';

export default class ArtistProfileService {
  private readonly app: Vue;

  public constructor(app: Vue) {
    this.app = app;
  }

  public get getId(): number {
    return Number(this.app.$route.params.id);
  }

  public get getTopAlbums(): Array<AlbumResponseInterface> {
    return mocks.artist_1.top_albums; // FIX: Изменить на реальные данные (Топ альбомы артиста)
  }

  public get getTopTracks(): Array<TrackResponseInterface> {
    return mocks.artist_1.top_tracks; // FIX: Изменить на реальные данные (Топ треки артиста)
  }

  public get getTopClips(): Array<ClipResponseInterface> {
    return mocks.artist_1.top_clips; // FIX: Изменить на реальные данные (Топ клипы артиста)
  }

  public get getPseudonym(): string {
    return mocks.artist_1.name; // FIX: Изменить на реальные данные (Псевдоним артиста)
  }

  public get getDescription(): string {
    return mocks.artist_1.description; // FIX: Изменить на реальные данные (Описание артиста)
  }

  public get getBackgroundLink(): string {
    return mocks.artist_1.background; // FIX: Изменить на реальные данные (Фон артиста)
  }

  public get getSimilarArtists(): Array<ArtistCardResponseInterface> {
    return mocks.artist_1.similar_artists; // FIX: Изменить на реальные данные (Похожие артисты)
  }
}
