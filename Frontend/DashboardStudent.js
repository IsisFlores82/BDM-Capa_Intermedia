document.addEventListener('DOMContentLoaded', function() {
    var carouselElement = document.querySelector('#categoriesCarousel');
    var carouselInner = carouselElement.querySelector('.carousel-inner');
    var carouselItems = carouselElement.querySelectorAll('.carousel-item');
    var totalItems = carouselItems.length;
    var visibleItems = 3;  // Número de elementos visibles
    var itemWidth = carouselItems[0].offsetWidth;  // Ancho de cada elemento
    var maxScrollPosition = (itemWidth * totalItems) - (itemWidth * visibleItems);  // Máximo desplazamiento
    var scrollPosition = 0;

    carouselElement.querySelector('.carousel-control-next').addEventListener('click', function() {
        if (scrollPosition < maxScrollPosition) {
            scrollPosition += itemWidth;
            carouselInner.scroll({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }
    });

    carouselElement.querySelector('.carousel-control-prev').addEventListener('click', function() {
        if (scrollPosition > 0) {
            scrollPosition -= itemWidth;
            carouselInner.scroll({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }
    });
});