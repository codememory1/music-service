declare class VueI18n {
  t(key: string, values?: any[] | { [key: string]: any }): string;
  t(key: string, locale: string, values?: any[] | { [key: string]: any }): string;
}
