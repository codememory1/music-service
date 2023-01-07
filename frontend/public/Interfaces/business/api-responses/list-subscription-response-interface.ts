interface SubscriptionPermissionInterface {
  permission_key: {
    title: string;
  };
}

interface SubscriptionInterface {
  id: number;
  title: string;
  description: string;
  old_price: number | null;
  price: number;
  is_recommend: boolean;
  status: string;
  permissions: Array<SubscriptionPermissionInterface>;
}

export { SubscriptionPermissionInterface, SubscriptionInterface };
