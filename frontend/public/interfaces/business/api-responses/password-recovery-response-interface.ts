interface PasswordRecoveryResponseInterface {
  user: {
    id: number;
    email: string;
  };
  status: string;
  ttl: number;
  created_at: string;
}

export default PasswordRecoveryResponseInterface;
