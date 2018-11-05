window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;

require('bootstrap');
require('@fortawesome/fontawesome-free/js/fontawesome.min.js');

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function () {
    $('.confirm-delete').on('click', function () {
        return confirm('Are you sure?');
    })
});