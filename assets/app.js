/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import './bootstrap';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const bar = document.getElementById('bar');
const percent = document.getElementById('bar-percent');

const rotation = parseInt(Math.min((percent.innerHTML * 1.8), 360), 10);

if (parseInt(percent.innerHTML, 10) >= 100) {
    bar.style.borderTopColor = "red";
    bar.style.borderLeftColor = "red";
}


bar.style.transform = `rotate(${rotation}deg)`;
