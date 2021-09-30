// makes sure the whole site is loaded
        $('#status').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350).css({
            'overflow': 'visible'
        });
        $.vegas('slideshow', {
            delay: 8000,
            backgrounds: [{
                src: './assets_extended/img/securebg_4.jpg',
                fade: 2000
            }
            // , {
            //     src: '../assets/img/securebg_3.jpg',
            //     fade: 2000
            // }
            ]
        })('overlay', {
            src: '#'
        });
