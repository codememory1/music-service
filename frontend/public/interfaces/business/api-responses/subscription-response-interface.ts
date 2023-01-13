interface SubscriptionResponseInterface {
  id: number;
  title: string;
  description: string;
  old_price: number | null;
  price: number;
  is_recommend: boolean;
  status: string;
  ui_permissions: Array<string>;
}

export default SubscriptionResponseInterface;
