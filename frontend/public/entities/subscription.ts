import { SubscriptionType, SubscriptionPermissionType } from '~/types/responses/subscription';
import SubscriptionPermissionEntity from '~/entities/subscription-permission';

export default class Subscription {
  private readonly id: number;
  private readonly title: string;
  private readonly description: string;
  private readonly oldPrice: number | null;
  private readonly price: number;
  private readonly isRecommend: boolean;
  private readonly status: string;
  private readonly permissions: Array<SubscriptionPermissionEntity>;

  public constructor(data: SubscriptionType) {
    this.id = data.id;
    this.title = data.title;
    this.description = data.description;
    this.oldPrice = data.old_price;
    this.price = data.price;
    this.isRecommend = data.is_recommend;
    this.status = data.status;
    this.permissions = this.collectPermissionsInEntity(data.permissions);
  }

  public getId(): number {
    return this.id;
  }

  public getTitle(): string {
    return this.title;
  }

  public getDescription(): string {
    return this.description;
  }

  public getOldPrice(): number | null {
    return this.oldPrice;
  }

  public getPrice(): number {
    return this.price;
  }

  public getIsRecommend(): boolean {
    return this.isRecommend;
  }

  public getStatus(): string {
    return this.status;
  }

  public getPermissions(): Array<SubscriptionPermissionEntity> {
    return this.permissions;
  }

  private collectPermissionsInEntity(
    permissions: Array<SubscriptionPermissionType>
  ): Array<SubscriptionPermissionEntity> {
    const permissionEntities: Array<SubscriptionPermissionEntity> = [];

    permissions.forEach((permission) => {
      permissionEntities.push(new SubscriptionPermissionEntity(permission));
    });

    return permissionEntities;
  }
}
