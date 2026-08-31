// //
// console.log("start script")
// const maxLength = 255;

// window.updateCounter = function () {
//     const textarea = document.getElementById('message');
//     const count = textarea.value.length;

//     const counter = document.getElementById('charCount');
//     const warning = document.getElementById('charWarning');
//     const submitBtn = document.getElementById('submitBtn');

//     counter.textContent = `${count} / ${maxLength}`;

//     if (count > maxLength) {
//         counter.classList.add('text-red-600');
//         warning.classList.remove('hidden');
//         submitBtn.disabled = true;
//     } else {
//         counter.classList.remove('text-red-600');
//         warning.classList.add('hidden');
//         submitBtn.disabled = false;
//     }
// }
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
