import './bootstrap.js';

import 'flowbite';
//import 'flowbite-datepicker';

AOS.init();

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("header").classList.add("bg-dark-500", "backdrop-blur-md", "shadow-lg");
    } else {
        document.getElementById("header").classList.remove("bg-dark-500", "backdrop-blur-md", "shadow-lg");
    }
}
