type SubscriptionPermissionType = {
  permission_key: {
    title: string;
  };
};

type SubscriptionType = {
  id: number;
  title: string;
  description: string;
  old_price: number | null;
  price: number;
  is_recommend: boolean;
  status: string;
  permissions: Array<SubscriptionPermissionType>;
};

type SubscriptionsResponseType = {
  http_code: number;
  platform_code: number;
  data: Array<SubscriptionType>;
};

export { SubscriptionPermissionType, SubscriptionType, SubscriptionsResponseType };
