window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;

require('bootstrap');
require('@fortawesome/fontawesome-free/js/fontawesome.min.js');

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});