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
});