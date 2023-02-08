export default function (
  event: PointerEvent,
  showingElement: HTMLElement,
  relativeToWindow: HTMLElement,
  windowSizeCorrection: { width: number; height: number } = { width: 0, height: 0 }
): { top: number; left: number } {
  let top: number;
  let left: number;

  const showingElementRect = showingElement.getBoundingClientRect();
  const windowRect = relativeToWindow.getBoundingClientRect();

  // Sizes
  const showingElementWidth = showingElementRect.width;
  const showingElementHeight = showingElementRect.height;
  const windowWidth = windowRect.width - windowSizeCorrection.width;
  const windowHeight = windowRect.height - windowSizeCorrection.height;

  // Positions
  const mouseX = event.clientX - windowRect.left;
  const mouseY = event.clientY;

  // Definition horizontal position
  if (mouseX + showingElementWidth > windowWidth) {
    left = mouseX - showingElementWidth;
  } else {
    left = mouseX;
  }

  // Definition vertical position
  if (mouseY + showingElementHeight > windowHeight) {
    top = mouseY - showingElementHeight;
  } else {
    top = mouseY;
  }

  return { top, left };
}
