import { SubscriptionPermissionKeyType } from '~/types/responses/subscription';

export default class SubscriptionPermissionKey {
  private readonly title: string;

  public constructor(data: SubscriptionPermissionKeyType) {
    this.title = data.title;
  }

  public getTitle(): string {
    return this.title;
  }
}
