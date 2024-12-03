renderSearchOverlay();

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

const renderSearchResults = (response, err) => {
    if (err) {
        console.error(err);
        searchOverlayContent.insertAdjacentHTML('beforeend', '<p>An error occurred. PLease try later.</p>');
        return;
    }
    searchOverlayContent.insertAdjacentHTML('beforeend', `<div class="row">
        <div class="row">
            <div class="one-third">
                <h2 class="search-overlay__section-title">General info</h2>
                ${renderItemsByKey(response, 'generalInfo', 'general info')}
            </div>
            <div class="one-third">
                <h2 class="search-overlay__section-title">Programs</h2>
                ${renderItemsByKey(response, 'programs')}
                <h2 class="search-overlay__section-title">Professors</h2>
                ${renderItemsByKey(response, 'professors')}            
            </div>
            <div class="one-third">
                <h2 class="search-overlay__section-title">Campuses</h2>
                ${renderItemsByKey(response, 'campuses')}
                <h2 class="search-overlay__section-title">Events</h2>
                ${renderItemsByKey(response, 'events')}            
            </div>        
        </div>
    </div>`)
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
    fetch(`http://localhost:8080/wp-json/university/v1/search?term=${searchValue}&page=1&limit=-1`)
        .then(res => res.json())
        .then(res => renderSearchResults(res, null))
        .catch(err => renderSearchResults(null, err))
        .finally(hideSpinner);
};

const inputChangeHandler = ($event) => {
    const { value } = $event.target;

    timeoutId && clearTimeout(timeoutId);

    if (!value)
        return hideSpinner();

    showSpinner();
    searchOverlayContent.innerHTML = '';
    timeoutId = setTimeout(requestData, 100, value);
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

function renderSearchOverlay() {
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

const renderItemsByKey = (response, key, shortDescription) => {
    let ulClasses = '';
    if (key === 'professors') ulClasses = 'professor-cards';
    else if (key !== 'events') ulClasses = 'link-list min-list';
    return response[key].length
        ?   `<ul class="${ulClasses}">
                ${response[key].map(renderItem(key)).join('')}
            </ul>`
        :   `<p>No ${shortDescription ?? key} matche(s) that search.</p>`;
}

const renderItem = (key) => {
    switch (key) {
        case 'professors': return i => `<li class="professor-card__list-item">
                <a class="professor-card" href="${i.permalink}" >
                    <img class="professor-card__image" src="${i.thumbnail}" alt="${i.title}" >
                    <span class="professor-card__name">${i.title}</span>        
                </a>
            </li>`;
        case 'events': return i => `<div class="event-summary">
                <a class="event-summary__date t-center" href="${i.permalink}">
                    <span class="event-summary__month">${i.month}</span>
                    <span class="event-summary__day">${i.day}</span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a
                        href="${i.permalink}">${i.title}</a></h5>
                    <p>
                        ${i.content}
                        <a href="${i.permalink}" class="nu gray">Learn more</a>
                    </p>
                </div>
            </div>`;
        default: return i => `<li><a href="${i.permalink}">${i.title}</a> ${i.author ? ` by ${i.author}` : ''}</li>`;
    }
};
