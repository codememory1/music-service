import PerformerType from '~/types/business/performer-type';

interface ClipResponseInterface {
  id: number;
  title: string;
  image: string;
  duration: string;
  is_obscene_words: boolean;
  performers: Array<PerformerType>;
  created_at: string;
}

export default ClipResponseInterface;
