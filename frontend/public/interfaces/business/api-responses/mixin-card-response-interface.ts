import ArtistCardResponseInterface from '~/interfaces/business/api-responses/artist-card-response-interface';
import PerformerType from '~/types/business/performer-type';

interface MixinCardResponseInterface {
  id: number;
  title: string;
  artists: Array<ArtistCardResponseInterface>;
  performers: Array<PerformerType>;
  created_at: string;
}

export default MixinCardResponseInterface;
