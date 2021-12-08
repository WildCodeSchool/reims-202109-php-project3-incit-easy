/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const bar = document.getElementById('bar');
const percent = document.getElementById('bar-percent');

const rotation = parseInt(45 + (percent.innerHTML * 1.8), 10);

bar.style.transform = `rotate(${rotation}deg)`;
