type ValueType = string | number | null | undefined | unknown;

interface Array<T> {
  removeObjectByKey(byKey: string, value: ValueType): Array<T>;
  removeByValue(value: ValueType): Array<T>;
  remove(index: number): Array<T>;
  findObjectByKey(
    byKey: string,
    value: string | number | null | undefined | unknown
  ): T | undefined;
  next(by: (el: T) => boolean, ifSuccessBy?: (el: T) => void): T;
  prev(by: (el: T) => boolean, ifSuccessBy?: (el: T) => void): T;
}

// eslint-disable-next-line no-extend-native
Array.prototype.removeObjectByKey = function (byKey, value) {
  for (let i = 0; this.length; i++) {
    if (this[i][byKey] === value) {
      this.remove(i);
    }
  }
  return this;
};

// eslint-disable-next-line no-extend-native
Array.prototype.removeByValue = function (value) {
  const index = this.indexOf(value);

  if (index > -1) {
    this.remove(index);
  }

  return this;
};

// eslint-disable-next-line no-extend-native
Array.prototype.remove = function (index) {
  this.splice(index, 1);

  return this;
};

// eslint-disable-next-line no-extend-native
Array.prototype.findObjectByKey = function (byKey, value) {
  for (let i = 0; this.length; i++) {
    if (this[i][byKey] === value) {
      return this[i];
    }
  }
  return undefined;
};

// eslint-disable-next-line no-extend-native
Array.prototype.next = function (by, ifSuccessBy) {
  let currentIndex;

  this.forEach((el, index) => {
    if (by(el)) {
      if (undefined !== ifSuccessBy) {
        ifSuccessBy(el);
      }

      currentIndex = index;
    }
  });

  if (currentIndex === undefined || currentIndex === this.length - 1) {
    return this[0];
  }

  return this[currentIndex + 1];
};

// eslint-disable-next-line no-extend-native
Array.prototype.prev = function (by, ifSuccessBy) {
  let currentIndex;

  this.forEach((el, index) => {
    if (by(el)) {
      if (undefined !== ifSuccessBy) {
        ifSuccessBy(el);
      }

      currentIndex = index;
    }
  });

  if (currentIndex === undefined || currentIndex === 0) {
    return this[this.length - 1];
  }

  return this[currentIndex - 1];
};
