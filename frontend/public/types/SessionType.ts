export type SessionType = {
  id: number;
  isActive: boolean;
  ip: string;
  browser: string | null;
  device: string | null;
  operatingSystem: string | null;
  city: string | null;
  country: string | null;
  coordinates: {
    latitude: number | null;
    longitude: number | null;
  };
  lastActivity: string;
  countryCode: string | null;
  region: string | null;
  regionName: string | null;
  timezone: string | null;
};
