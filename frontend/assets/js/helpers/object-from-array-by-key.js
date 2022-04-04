export default function (arrayWithObjects, keyToObject, keyValue) {
  let obj = false;

  arrayWithObjects.forEach((el) => {
    if (el[keyToObject] === keyValue) {
      obj = el;
    }
  });

  return obj;
}
