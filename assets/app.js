/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';
import './components/custom';

const $ = require('jquery');

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})

const generateRandomColor = () => {
    const randomColor = Math.floor(Math.random()*16777215).toString(16);
    return "#" + randomColor;
}

$(function () {
    $('#random-color').on('click', function () {
        generateColorInput();
    })

    function generateColorInput() {
        $('#color_theme_bgColor').val(generateRandomColor());
        $('#color_theme_secondaryColor').val(generateRandomColor());
        $('#color_theme_textColor').val(generateRandomColor());
    }

    generateColorInput();

    $('.getColor').on('click', function () {
        console.log('get color');
        let bgColor = $(this).data('bg');
        let secondaryColor = $(this).data('secondary');
        let textColor = $(this).data('text');

        $('#color_theme_bgColor').val(bgColor);
        $('#color_theme_secondaryColor').val(secondaryColor);
        $('#color_theme_textColor').val(textColor);
    });
});
