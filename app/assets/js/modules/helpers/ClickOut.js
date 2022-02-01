export default function (container, callback) {
  document.addEventListener("click", (event) => {
    const clickOut = !container.contains(event.target);

    callback(clickOut);
  });
}
