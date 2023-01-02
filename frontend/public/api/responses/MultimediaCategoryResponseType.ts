type MultimediaCategoryType = {
  id: number;
  title: string;
};

type MultimediaCategoryResponseType = {
  http_code: number;
  platform_code: number;
  data: Array<MultimediaCategoryType>;
};

export { MultimediaCategoryType, MultimediaCategoryResponseType };
