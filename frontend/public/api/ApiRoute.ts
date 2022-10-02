import { EnumSortable } from '~/Enums/EnumSortable';
import { EnumRequestMethods } from '~/Enums/EnumRequestMethods';

const httpBuildQuery = require('http-build-query');

export class ApiRoute {
  private readonly path: string;
  private readonly method: EnumRequestMethods;
  private readonly filters: Array<string>;
  private readonly sorts: Array<string>;
  private queryData: {
    filters: { name: string; value: string | number }[];
    sorts: { name: string; value: string }[];
  } = {
    filters: [],
    sorts: []
  };

  constructor(
    path: string,
    method: EnumRequestMethods = EnumRequestMethods.Get,
    filters: Array<string> = [],
    sorts: Array<string> = []
  ) {
    this.path = path;
    this.method = method;
    this.filters = filters;
    this.sorts = sorts;
  }

  public addFilter(name: string, value: string | number): ApiRoute {
    if (this.filters.includes(name)) {
      this.queryData.filters.push({ name, value });
    }

    return this;
  }

  public addSort(name: string, as: EnumSortable = EnumSortable.Desc) {
    if (this.sorts.includes(name)) {
      this.queryData.sorts.push({ name, value: as });
    }

    return this;
  }

  public getPath(): string {
    const query = httpBuildQuery(this.queryData);

    return query === '' ? this.path : decodeURI(`${this.path}?${query}`);
  }

  public getMethod(): string {
    return this.method;
  }
}
