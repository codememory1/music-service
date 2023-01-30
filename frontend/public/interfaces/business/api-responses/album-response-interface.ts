import PerformerType from '~/types/business/performer-type';

interface AlbumResponseInterface {
  id: number;
  title: string;
  image: string;
  created_at: string;
  performers: Array<PerformerType>;
}

export default AlbumResponseInterface;
