import PerformerType from '~/types/business/performer-type';

interface TrackResponseInterface {
  id: number;
  title: string;
  image: string;
  duration: string;
  performers: Array<PerformerType>;
}

export default TrackResponseInterface;
