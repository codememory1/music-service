import { Vue } from 'vue-property-decorator';
import { SubscriptionResponseInterface } from '~/interfaces/business/api-responses/subscription-response-interface';

export default class BuySubscriptionService {
  public readonly app: Vue;
  private readonly data: SubscriptionResponseInterface;

  public constructor(app: Vue, data: SubscriptionResponseInterface) {
    this.app = app;
    this.data = data;
  }

  public getData(): SubscriptionResponseInterface {
    return this.data;
  }

  public buy(): void {}
}
