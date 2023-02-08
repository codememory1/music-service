interface UserNotificationResponseInterface {
  id: number;
  from: {
    pseudonym: string;
    photo: string;
  };
  type: string;
  title: string;
  message: string;
  action: object;
  created_at: string;
}

export default UserNotificationResponseInterface;
