interface PasswordResetResponseInterface {
  user: {
    id: number;
    email: string;
  };
  code: number;
  status: string;
  created_at: string;
  updated_at: string;
}

export default PasswordResetResponseInterface;
