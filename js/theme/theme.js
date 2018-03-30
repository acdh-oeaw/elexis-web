/**
 * Theme.js
 */

// Init Feather
feather.replace();

jQuery(function ($) {
"use strict";
/* You can safely use $ in this code block to reference jQuery */

$(window).load(function() {

  // Cards masonary layout
  $('.card-wrapper').isotope({
    itemSelector: '.card',
    masonry: {
      columnWidth: '.card'
    }
  });

  // Fixed navbard distance to main
  var navbarHeight = $('.navbar.fixed-top').innerHeight();
  if (navbarHeight) {
    $('#wrapper-navbar').css("margin-bottom", navbarHeight);
  }


});

/* You can safely use $ in this code block to reference jQuery */
});
