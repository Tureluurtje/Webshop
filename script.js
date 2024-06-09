window.addEventListener('scroll', parallax);

function parallax() {
    const parallaxItems = document.querySelectorAll('.parallax-item');

    parallaxItems.forEach(item => {
        const depth = item.getAttribute('data-depth');
        const scrollY = window.pageYOffset;
        const itemTop = item.getBoundingClientRect().top;
        const itemHeight = item.offsetHeight;
        const itemCenter = itemTop + itemHeight / 2;
        const viewportCenter = window.innerHeight / 2;

        const distanceFromCenter = itemCenter - viewportCenter;
        const translateY = distanceFromCenter * depth;

        item.style.transform = `translateY(${translateY}px)`;
    });
}
