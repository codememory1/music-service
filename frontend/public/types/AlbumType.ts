import { ArtistType } from '~/types/ArtistType';

export type AlbumType = {
  id: number;
  title: string;
  image: string;
  performers: ArtistType[];
};
