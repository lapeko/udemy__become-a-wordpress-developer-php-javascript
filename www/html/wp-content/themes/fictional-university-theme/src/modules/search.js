const openSearchBtn = document.querySelector('.search-trigger.js-search-trigger');
const closeSearchBtn = document.querySelector('.search-overlay__close');
const searchOverlay = document.querySelector('.search-overlay');

const activeOverlayClass = 'search-overlay--active';

const openOverlay = () => searchOverlay.classList.add(activeOverlayClass);
const closeOverlay = () => searchOverlay.classList.remove(activeOverlayClass);

openSearchBtn.addEventListener('click', openOverlay);
closeSearchBtn.addEventListener('click', closeOverlay);