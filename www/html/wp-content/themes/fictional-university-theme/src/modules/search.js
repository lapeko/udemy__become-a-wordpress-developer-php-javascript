addOverlayIntoDom();

const openSearchBtn = document.querySelector('.search-trigger.js-search-trigger');
const closeSearchBtn = document.querySelector('.search-overlay__close');
const searchOverlay = document.querySelector('.search-overlay');
const searchOverlayContent = document.getElementById('search-overlay-content');
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

showSearchResults = (items, err) => {
    searchOverlayContent.innerHTML = '<h2 class="search-overlay__section-title">General information</h2>';
    if (err) {
        console.error(err);
        searchOverlayContent.insertAdjacentHTML('beforeend', '<p>An error occurred. PLease try later.</p>');
        return;
    }
    if (!items?.length) {
        searchOverlayContent.insertAdjacentHTML('beforeend', '<p>No general information matches that search.</p>');
        return;
    }
    searchOverlayContent.insertAdjacentHTML('beforeend', `<ul class="link-list min-list">
        ${items.map(i => `<li><a href="${i.link}">${i.title.rendered}</a> ${i.authorName ? ` by ${i.authorName}` : ''}</li>`).join('')}
    </ul>`)
}

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
    Promise.all([
        fetch(`http://localhost:8080/wp-json/wp/v2/posts?search=${searchValue}`).then(res => res.json()),
        fetch(`http://localhost:8080/wp-json/wp/v2/event?search=${searchValue}`).then(res => res.json()),
    ])
        .then(([json1, json2]) => [...json1, ...json2])
        .then(res => showSearchResults(res, null))
        .catch(err => showSearchResults(null, err))
        .finally(hideSpinner);
};

const inputChangeHandler = ($event) => {
    const { value } = $event.target;

    timeoutId && clearTimeout(timeoutId);

    if (!value)
        return hideSpinner();

    showSpinner();
    searchOverlayContent.innerHTML = '';
    timeoutId = setTimeout(requestData, 2000, value);
}

const openOverlay = () => {
    if (overlayOpened || allTextInputs.includes(document.activeElement)) return;
    searchInput.value = '';
    searchOverlay.classList.add(activeOverlayClass);
    document.body.classList.add(bodyNoScrollClass);
    setTimeout(() => {
        searchInput.focus();
        searchInput.addEventListener('input', inputChangeHandler);
    }, 100);
    overlayOpened = true;
    hideSpinner();
    searchOverlayContent.innerHTML = '';
}
const closeOverlay = () => {
    if (!overlayOpened) return;
    searchOverlay.classList.remove(activeOverlayClass);
    document.body.classList.remove(bodyNoScrollClass);
    timeoutId && clearTimeout(timeoutId);
    overlayOpened = false;
};

openSearchBtn.addEventListener('click', openOverlay);
closeSearchBtn.addEventListener('click', closeOverlay);

document.addEventListener('keydown', e => {
    switch (e.key) {
        case 's': openOverlay(); break;
        case 'Escape': closeOverlay(); break;
    }
});

function addOverlayIntoDom() {
    const overlayDiv = document.createElement('div');
    overlayDiv.className = 'search-overlay';
    overlayDiv.innerHTML = `<div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input
                id="search-term"
                class="search-term"
                placeholder="What are you looking for?"
                autocomplete="false"
            >
            <i class="fa fa-window-close search-overlay__close"></i>
        </div>
    </div>
    <div class="container">
        <div class="spinner-loader"></div>
        <div class="container" id="search-overlay-content"></div>        
    </div>`;
    document.body.appendChild(overlayDiv);
}
