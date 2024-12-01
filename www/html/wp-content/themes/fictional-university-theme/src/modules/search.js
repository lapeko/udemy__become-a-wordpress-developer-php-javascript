const openSearchBtn = document.querySelector('.search-trigger.js-search-trigger');
const closeSearchBtn = document.querySelector('.search-overlay__close');
const searchOverlay = document.querySelector('.search-overlay');

const activeOverlayClass = 'search-overlay--active';
const bodyNoScrollClass = 'body-no-scroll';

let overlayOpened = false;

const openOverlay = () => {
    if (overlayOpened) return;
    searchOverlay.classList.add(activeOverlayClass);
    document.body.classList.add(bodyNoScrollClass);
    overlayOpened = true;
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