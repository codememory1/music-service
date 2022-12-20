import { ArtistType } from '~/types/ArtistType';

export type TrackType = {
  id: number;
  title: string;
  image: string;
  performers: ArtistType[];
  duration: string;
};
