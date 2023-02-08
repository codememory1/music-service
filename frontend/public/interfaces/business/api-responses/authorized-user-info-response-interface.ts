interface AuthorizedUserInfoResponseInterface {
  id: number;
  email: string;
  profile: {
    id: number;
    pseudonym: string;
    photo: string | null;
    date_birth: string | null;
    design?: []; // FIX: Настроить дизайн
  };
  role: {
    id: number;
    key: string;
    permissions: Array<{ permission_key: string }>;
    short_description: string | null;
    title: string | null;
    created_at: string;
    updated_at: string | null;
  };
  settings: []; // FIX: Настройки настройки
  status: string;
  subscription: {
    id: number;
    permissions: Array<{ permission_key: { key: string; title: string | null } }>;
  };
}

export default AuthorizedUserInfoResponseInterface;
