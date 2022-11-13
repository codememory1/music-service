export default function isEmpty(value: any): boolean {
  return value === '' || value === null || value === false || value.length === 0;
}
