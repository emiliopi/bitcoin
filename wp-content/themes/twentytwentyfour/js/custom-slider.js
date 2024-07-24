jQuery(document).ready(function($) {
    $('.books-list').slick({
        slidesToShow: 2, // Número de libros a mostrar en una vista
        slidesToScroll: 1,
        infinite: true,
        dots: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});
