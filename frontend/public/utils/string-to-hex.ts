export default function (text: string): string {
  let hash: number = 0;

  for (let i = 0; i < text.length; i++) {
    hash = text.charCodeAt(i) + ((hash << 5) - hash);
  }

  let hex = '#';

  for (let i = 0; i < 3; i++) {
    hex += ('00' + ((hash >> (i * 8)) & 0xff).toString(16)).slice(-2);
  }

  return hex;
}
