interface UserSessionResponseInterface {
  id: number;
  access_token: string;
  refresh_token: string;
  is_active: boolean;
  ip: string | null;
  browser: string | null;
  device: string | null;
  operating_system: string | null;
  city: string | null;
  country: string | null;
  coordinates: {
    latitude: number | null;
    longitude: number | null;
  };
  last_activity: string;
  created_at: string;
  updated_at: string;
}

export default UserSessionResponseInterface;
