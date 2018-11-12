window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;

require('bootstrap');
require('@fortawesome/fontawesome-free/js/fontawesome.min.js');
require('select2/dist/js/select2.min');

import Chart from 'chart.js';

window.randomColorGenerator = function() {
    return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
};

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.confirm-delete').on('click', function () {
        return confirm('Are you sure?');
    });
});