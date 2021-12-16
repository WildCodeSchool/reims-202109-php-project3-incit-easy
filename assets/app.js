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

const percent = document.getElementById('bar-percent');

const rotation = parseInt(Math.min((percent.innerHTML * 1.8), 360), 10);

const firstWarning = document.querySelector('.first-warning');
const secondWarning = document.querySelector('.second-warning');
const finalWarning = document.querySelector('.final-warning');

document.documentElement.style.setProperty('--rotation', `${rotation}deg`);

if (percent.innerHTML <= 100) {
    document.documentElement.style.setProperty('--final-color', '#eee');
} else if (percent.innerHTML > 100 && percent.innerHTML < 133) {
    firstWarning.style.backgroundColor = 'yellow';
} else if (percent.innerHTML > 133 && percent.innerHTML < 166) {
    firstWarning.style.backgroundColor = 'yellow';
    secondWarning.style.backgroundColor = 'orange';
} else {
    firstWarning.style.backgroundColor = 'yellow';
    secondWarning.style.backgroundColor = 'orange';
    finalWarning.style.backgroundColor = 'red';
}
