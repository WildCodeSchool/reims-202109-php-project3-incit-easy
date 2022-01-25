/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import axios from 'axios';
import './bootstrap';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const percent = document.getElementById('bar-percent');

if (percent != null) {
    const rotation = parseInt(Math.min((percent.innerHTML * 1.8), 360), 10);

    const warningContainer = document.querySelector('.warning-container');
    const firstWarning = document.querySelector('.first-warning');
    const secondWarning = document.querySelector('.second-warning');
    const finalWarning = document.querySelector('.final-warning');
    const progressBar = document.querySelector('.bar');

    document.documentElement.style.setProperty('--rotation', `${rotation}deg`);

    if (percent.innerHTML <= 100) {
        warningContainer.style.cssText += 'display: none;';
        document.documentElement.style.setProperty('--final-color', '#eee');
        document.documentElement.style.setProperty('--final-color-two', '#2bad93');
    } else if (percent.innerHTML > 100 && percent.innerHTML < 113) {
        firstWarning.style.backgroundColor = '#FCFF4C';
        firstWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 1.5s;';
        document.documentElement.style.setProperty('--final-color', '#FCFF4C');
        document.documentElement.style.setProperty('--final-color-two', '#FCFF4C');
    } else if (percent.innerHTML > 113 && percent.innerHTML < 136) {
        firstWarning.style.backgroundColor = '#FCFF4C';
        secondWarning.style.backgroundColor = '#ffb625';
        firstWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 1.5s;';
        secondWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 2s;';
        document.documentElement.style.setProperty('--final-color', '#ffb625');
        document.documentElement.style.setProperty('--final-color-two', '#ffb625');
    } else {
        firstWarning.style.backgroundColor = '#FCFF4C';
        secondWarning.style.backgroundColor = '#ffb625';
        finalWarning.style.backgroundColor = '#ff4949';
        firstWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 1.5s;';
        secondWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 2s;';
        finalWarning.style.cssText += 'animation: pop 1s normal forwards; animation-delay: 3s;';
        document.documentElement.style.setProperty('--final-color', '#ff4949');
        document.documentElement.style.setProperty('--final-color-two', '#ff4949');
    }
}

const LIKE_ICON = 'far fa-heart';
const UNLIKE_ICON = 'fas fa-heart';
Array.from(document.querySelectorAll('a.js-like')).forEach((link) => {
    async function onClickLink(event) {
        event.preventDefault();
        const url = this.href;
        const icone = this.querySelector('i');
        const count = this.querySelector('span.js-likes');
        try {
            const result = await axios.post(url);
            const { data } = result;
            icone.className = icone.className === LIKE_ICON ? UNLIKE_ICON : LIKE_ICON;
            count.textContent = data.likes;
        } catch (error) {
            if (error.response.status === 403) {
                window.location = '/login';
            }
        }
    }
    link.addEventListener('click', onClickLink);
});
