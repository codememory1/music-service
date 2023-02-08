export default function (container: Node, event: Event): boolean {
  return container.contains(event.target as Node);
}
