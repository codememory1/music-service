export default function (hex, opacity) {
  return `rgba(${hex
    .substr(1)
    .match(/../g)
    .map((x) => +`0x${x}`)},${opacity})`;
}
