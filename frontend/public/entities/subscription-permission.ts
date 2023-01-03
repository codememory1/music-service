import SubscriptionPermissionKeyEntity from '~/entities/subscription-permission-key';
import { SubscriptionPermissionType } from '~/types/responses/subscription';

export default class SubscriptionPermission {
  private readonly permissionKey: SubscriptionPermissionKeyEntity;

  public constructor(data: SubscriptionPermissionType) {
    this.permissionKey = new SubscriptionPermissionKeyEntity(data.permission_key);
  }

  public getPermissionKey(): SubscriptionPermissionKeyEntity {
    return this.permissionKey;
  }
}
