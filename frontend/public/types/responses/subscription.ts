export type SubscriptionPermissionKeyType = {
  title: string;
};

export type SubscriptionPermissionType = {
  permission_key: SubscriptionPermissionKeyType;
};

export type SubscriptionType = {
  id: number;
  title: string;
  description: string;
  old_price: number | null;
  price: number;
  is_recommend: boolean;
  status: string;
  permissions: Array<SubscriptionPermissionType>;
};
