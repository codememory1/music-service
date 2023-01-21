import PerformerAlbumType from '~/types/business/performer-album-type';

interface AlbumResponseInterface {
  id: number;
  title: string;
  image: string;
  created_at: string;
  performers: Array<PerformerAlbumType>;
}

export default AlbumResponseInterface;
