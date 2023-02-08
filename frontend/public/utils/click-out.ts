import isEventBelongToContainer from '~/utils/is-event-belong-to-container';

export default function (container: Node, callback: (is: boolean, event: PointerEvent) => void) {
  document.addEventListener('click', (event: Event) => {
    const clickOut: boolean = !isEventBelongToContainer(container, event);

    callback(clickOut, event as PointerEvent);
  });
}
