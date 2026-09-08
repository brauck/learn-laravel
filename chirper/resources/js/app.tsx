//import './bootstrap'; // Здесь инициализируется наш echo.ts
// import './utils/echo'; // Импортируем нашу настройку Reverb вместо bootstr
// import React from 'react';
// import { createRoot } from 'react-dom/client';
// import { LikeButton } from './components/LikeButton'; // Путь к вашему React-компоненту

// // Ищем все элементы с классом react-like-button
// const likeButtonElements = document.querySelectorAll('.react-like-button');

// likeButtonElements.forEach((el) => {
//     // Безопасно извлекаем JSON-данные чирпа, которые мы передадим из Blade
//     const chirpData = el.getAttribute('data-chirp');
    
//     if (chirpData) {
//         const chirp = JSON.parse(chirpData);
        
//         // Рендерим React-компонент внутрь этого div
//         createRoot(el).render(
//             <React.StrictMode>
//                 <LikeButton initialChirp={chirp} />
//             </React.StrictMode>
//         );
//     }
// });

import React from 'react';
import { createRoot } from 'react-dom/client';
import { LikeButton } from './components/LikeButton';
import './utils/echo';

// Заставляем React подождать, пока браузер полностью построит HTML-дерево
document.addEventListener('DOMContentLoaded', () => {
    const likeButtonElements = document.querySelectorAll('.react-like-button');

    likeButtonElements.forEach((el) => {
        const chirpData = el.getAttribute('data-chirp');
        
        if (chirpData) {
            const chirp = JSON.parse(chirpData);
            
            createRoot(el).render(
                <React.StrictMode>
                    <LikeButton initialChirp={chirp} />
                </React.StrictMode>
            );
        }
    });
});

