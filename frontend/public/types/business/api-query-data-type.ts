export type ApiQueryFilterType = {
  name: string;
  value: string | number;
};

export type ApiQuerySortType = {
  name: string;
  value: 'ASC' | 'DESC';
};

export type ApiQueryDataType = {
  filters: Array<ApiQueryFilterType>;
  sorts: Array<ApiQuerySortType>;
};
