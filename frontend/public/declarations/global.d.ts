export {};

declare global {
  interface Array<T> {
    removeObjectByKey(byKey: string, value: string | number | null | undefined | unknown): Array<T>;
    removeByValue(value: string | number | null | undefined | unknown): Array<T>;
    remove(index: number): Array<T>;
    findObjectByKey(
      byKey: string,
      value: string | number | null | undefined | unknown
    ): T | undefined;
    next(by: (el: T) => boolean, ifSuccessBy?: (el: T) => void): T;
    prev(by: (el: T) => boolean, ifSuccessBy?: (el: T) => void): T;
  }
}
