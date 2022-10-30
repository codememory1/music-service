export default function (container: Node, callback: (is: boolean, event: PointerEvent) => void) {
  document.addEventListener('click', (event: Event) => {
    const clickOut: boolean = !container.contains(event.target as Node);

    callback(clickOut, event as PointerEvent);
  });
}
