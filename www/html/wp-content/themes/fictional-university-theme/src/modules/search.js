const openSearchBtn = document.querySelector('.search-trigger.js-search-trigger');
const closeSearchBtn = document.querySelector('.search-overlay__close');
const searchOverlay = document.querySelector('.search-overlay');
const spinner = searchOverlay.querySelector('.spinner-loader');
const searchInput = document.getElementById('search-term');

const inputs = Array.from(document.querySelectorAll('input[type=text]'));
const textAreas = Array.from(document.querySelectorAll('textarea'));
const allTextInputs = inputs.concat(textAreas);

const activeOverlayClass = 'search-overlay--active';
const bodyNoScrollClass = 'body-no-scroll';

let overlayOpened = false;
let spinnerShown = false;

let timeoutId;

const showSpinner = () => {
    if (spinnerShown) return;
    spinner.classList.add("active");
    spinnerShown = true;
}

const hideSpinner = () => {
    if (!spinnerShown) return;
    spinner.classList.remove("active");
    spinnerShown = false;
}

const requestData = (searchValue) => {
    fetch(`http://localhost:8080/wp-json/wp/v2/posts?search=${searchValue}`)
        .then(res => res.json())
        .then(arr => arr?.map(post => post?.title?.rendered))
        .then(console.log)
        .catch(console.error)
        .finally(hideSpinner);
};

const inputChangeHandler = ($event) => {
    const { value } = $event.target;

    timeoutId && clearTimeout(timeoutId);

    if (!value)
        return hideSpinner();

    showSpinner();
    timeoutId = setTimeout(requestData, 2000, value);
}

const openOverlay = () => {
    if (overlayOpened || allTextInputs.includes(document.activeElement)) return;
    searchOverlay.classList.add(activeOverlayClass);
    document.body.classList.add(bodyNoScrollClass);
    setTimeout(() => {
        searchInput.focus();
        searchInput.addEventListener('input', inputChangeHandler);
    }, 20);
    overlayOpened = true;
    hideSpinner();
}
const closeOverlay = () => {
    if (!overlayOpened) return;
    searchOverlay.classList.remove(activeOverlayClass);
    document.body.classList.remove(bodyNoScrollClass);
    overlayOpened = false;
};

openSearchBtn.addEventListener('click', openOverlay);
closeSearchBtn.addEventListener('click', closeOverlay);

document.addEventListener('keydown', e => {
    switch (e.key) {
        case 's': openOverlay(); break;
        case 'Escape': closeOverlay(); break;
    }
})