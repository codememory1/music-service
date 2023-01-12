interface SubscriptionPermissionResponseInterface {
  permission_key: {
    title: string;
  };
}

interface SubscriptionResponseInterface {
  id: number;
  title: string;
  description: string;
  old_price: number | null;
  price: number;
  is_recommend: boolean;
  status: string;
  unique_permissions: Array<SubscriptionPermissionResponseInterface>;
}

export { SubscriptionPermissionResponseInterface, SubscriptionResponseInterface };
