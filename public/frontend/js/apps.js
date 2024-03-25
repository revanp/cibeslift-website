$('.slider-history').slick({
    centerPadding: '60px',
    slidesToShow: 4,
    responsive: [
        {
            breakpoint: 768,
            settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 1
            }
        }
    ]
});

$(document).ready(function() {
    if($(window).scrollTop() > 50) {
        if(!$('.sidebar').hasClass('active')){
            $(".header-home").addClass("bg-color-header-blue");
        }
    } else {
        if(!$('.sidebar').hasClass('active')){
            $(".header-home").removeClass("bg-color-header-blue");
        }
    }
});
$(window).on("scroll", function() {
    if($(window).scrollTop() > 50) {
        if(!$('.sidebar').hasClass('active')){
            $(".header-home").addClass("bg-color-header-blue");
        }
    } else {
        if(!$('.sidebar').hasClass('active')){
            $(".header-home").removeClass("bg-color-header-blue");
        }
    }
});

const items = document.querySelectorAll(".accordion button");

function toggleAccordion() {
    const itemToggle = this.getAttribute('aria-expanded');

    for (i = 0; i < items.length; i++) {
        items[i].setAttribute('aria-expanded', 'false');
    }

    if (itemToggle == 'false') {
        this.setAttribute('aria-expanded', 'true');
    }
}

items.forEach(item => item.addEventListener('click', toggleAccordion));

$('#sidebarToggle').on('click', function() {
    $('.sidebar').toggleClass('active');
    $(".header-home").addClass("bg-color-header-blue");
});

if ($(window).width() > 768) {
    $(".menu li.has-child").on({
        mouseenter: function () {
            $('.header-dropdown').addClass('active');
        },
        mouseleave: function () {
            $('.header-dropdown').removeClass('active');
        }
    });    
} else {
    $(".menu li.has-child").on('click', function() {
        $('.header-dropdown').addClass('active');
    });
    $('.closeMenus').on('click', function() {
        $('.header-dropdown').removeClass('active');
    });
}

$('.menuToggle').on('click', function() {
    $('.main-menu').addClass('active');
});

$('.closeMenu').on('click', function() {
    $('.main-menu').removeClass('active');
});

