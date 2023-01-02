export type SizeType = {
  size: number;
  name: string;
};

export default function (byte: number): SizeType {
  const kb = byte / 1000;
  const mb = kb / 1000;
  const gb = mb / 1000;
  const tb = gb / 1000;

  if (byte < 1000) {
    return {
      size: byte,
      name: 'B'
    };
  }

  if (kb < 1000) {
    return {
      size: kb,
      name: 'KB'
    };
  }

  if (mb < 1000) {
    return {
      size: mb,
      name: 'MB'
    };
  }

  if (gb < 1000) {
    return {
      size: gb,
      name: 'GB'
    };
  }

  if (tb < 1000) {
    return {
      size: tb,
      name: 'TB'
    };
  }

  return {
    size: tb / 1000,
    name: 'PT'
  };
}
