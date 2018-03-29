/**
 * Theme.js
 */

// Init Feather
feather.replace();

jQuery(function ($) {
"use strict";
/* You can safely use $ in this code block to reference jQuery */

$(window).load(function() {

  $('.card-wrapper').isotope({
    itemSelector: '.card',
    masonry: {
      columnWidth: '.card'
    }
  });

});

/* You can safely use $ in this code block to reference jQuery */
});
