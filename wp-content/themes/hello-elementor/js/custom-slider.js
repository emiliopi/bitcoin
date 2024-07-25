jQuery(document).ready(function($) {
    $('.books-list').slick({
        slidesToShow: 3, // Número de libros a mostrar en una vista
        slidesToScroll: 1,
        infinite: false,
        dots: true,
        arrows: false,
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
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 468,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});
