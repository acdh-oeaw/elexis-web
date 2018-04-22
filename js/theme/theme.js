/**
 * Theme.js
 */

// Init Feather
feather.replace();

// JQUERY
jQuery(function ($) {
"use strict";
/* You can safely use $ in this code block to reference jQuery */

$(document).ready(function() {

  // Cards masonary layout
  $('.card-wrapper').isotope({
    itemSelector: '.card',
    masonry: {
      columnWidth: '.card'
    }
  });

});

/* You can safely use $ in this code block to reference jQuery */
});
