interface ApiSuccessResponseInterface<D> {
  http_code: number;
  platform_code: number;
  data: D;
  meta?: {
    pagination?: {
      total_pages: number;
      current_page: number;
      current_limit: number;
    };
  };
}

export default ApiSuccessResponseInterface;
