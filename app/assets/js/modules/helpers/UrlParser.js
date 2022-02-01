const path = window.location.pathname;

function pathStartWith(prefix) {
    return null !== path.match(new RegExp('^\/' + prefix));
}

export {pathStartWith}