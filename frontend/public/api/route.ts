import { ViewSortableEnum } from '~/enums/view-sortable-enum';
import { HttpRequestMethodEnum } from '~/enums/http-request-method-enum';
import { ApiQueryDataType } from '~/types/business/api-query-data-type';

const httpBuildQuery = require('http-build-query');

export default class Route {
  private readonly path: string;
  private readonly method: HttpRequestMethodEnum;
  private readonly filters: Array<string>;
  private readonly sorts: Array<string>;
  private queryData: ApiQueryDataType = {
    filters: [],
    sorts: []
  };

  public constructor(
    path: string,
    method: HttpRequestMethodEnum = HttpRequestMethodEnum.GET,
    filters: Array<string> = [],
    sorts: Array<string> = []
  ) {
    this.path = path;
    this.method = method;
    this.filters = filters;
    this.sorts = sorts;
  }

  public addFilter(name: string, value: string | number): Route {
    if (this.filters.includes(name)) {
      this.queryData.filters.push({ name, value });
    }

    return this;
  }

  public addSort(name: string, as: ViewSortableEnum = ViewSortableEnum.Desc) {
    if (this.sorts.includes(name)) {
      this.queryData.sorts.push({ name, value: as });
    }

    return this;
  }

  public getPath(): string {
    const query = httpBuildQuery(this.queryData);

    return query === '' ? this.path : decodeURI(`${this.path}?${query}`);
  }

  public getMethod(): number {
    return this.method;
  }
}
