import { ResponseResultType } from '~/types/ResponseResultType';
import { ErrorResponseType } from '~/types/ErrorResponseType';

export interface IRequest<T> {
  send(host: string): Promise<ResponseResultType<T, ErrorResponseType>>;
}
