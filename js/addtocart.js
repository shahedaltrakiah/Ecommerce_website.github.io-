function getCountFromLocalStorage() {
    return parseInt(localStorage.getItem('cartCount')) || 0; 
}
function updateBadge(count) {
    const badge = document.querySelector('.notification-badge');
    badge.textContent = count ? `${count}` : ''; 
}
let count = getCountFromLocalStorage();
updateBadge(count);
const buttons = document.querySelectorAll('.btn-dua');
buttons.forEach(button => {
    button.addEventListener('click', () => {
        count++; 
        localStorage.setItem('cartCount', count); 
        updateBadge(count);
        alert('Item added to cart!');
    });
});