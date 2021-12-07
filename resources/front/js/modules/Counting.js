/**
 * Подсчет кол-во элементов в объектах массива
 *
 * @param arrayWithObjects
 * @param to            -> Ключи относительно элемента, через точку
 * @returns {number}
 */
export default function (arrayWithObjects, to) {
  let count = 0;
  const keys = Object.keys(arrayWithObjects);

  for (let i = 0; i < keys.length; i++) {
    const toArray = to.split(".");
    let object = arrayWithObjects[keys[i]];

    toArray.forEach((v) => {
      if (v in object && object[v] !== null && typeof object[v] === "object") {
        object = object[v];
      } else {
        object = [];
      }
    });

    count += object.length;
  }

  return count;
}
