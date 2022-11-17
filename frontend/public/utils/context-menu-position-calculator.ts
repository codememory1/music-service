export default function (contextMenuEvent: PointerEvent, contextMenu: Element) {
  const bodyRect = document.body.getBoundingClientRect();
  const contextMenuRect = contextMenu.getBoundingClientRect();
  const contextMenuX = contextMenuEvent.clientX - bodyRect.x + contextMenuRect.width;
  const contextMenuY = contextMenuEvent.clientY - bodyRect.y + contextMenuRect.height;

  let x: number;
  let y: number;

  if (contextMenuX > window.innerWidth) {
    x = contextMenuEvent.clientX - bodyRect.x - contextMenuRect.width;
  } else {
    x = contextMenuEvent.clientX - bodyRect.x;
  }

  if (contextMenuY > window.innerHeight) {
    y = contextMenuEvent.clientY - bodyRect.y - contextMenuRect.height;
  } else {
    y = contextMenuEvent.clientY - bodyRect.y;
  }

  return { x, y };
}
