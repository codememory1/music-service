export default function (container: Node, callback: (is: boolean) => void) {
  document.addEventListener('click', (event: Event) => {
    const clickOut: boolean = !container.contains(event.target as Node);

    callback(clickOut);
  });
}
