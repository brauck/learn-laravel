// import React, { useState, useEffect } from 'react';
// import { echo } from '../utils/echo';

// // Описываем интерфейс пропсов чирпа
// interface Chirp {
//     id: number;
//     likes_count: number;
//     is_liked: boolean;
// }

// interface LikeButtonProps {
//     initialChirp: Chirp;
// }

// // Описываем структуру данных, которая прилетит по WebSocket
// interface ChirpLikedEvent {
//     chirpId: number;
// }

// export const LikeButton: React.FC<LikeButtonProps> = ({ initialChirp }) => {
//     const [likesCount, setLikesCount] = useState<number>(initialChirp.likes_count);
//     const [isLiked, setIsLiked] = useState<boolean>(initialChirp.is_liked);

//     // useEffect(() => {
//     //     // Подключаемся к публичному каналу Reverb
//     //     const channel = echo.channel('chirps-activity');

//     //     // Слушаем событие лайка
//     //     // channel.listen('.ChirpLiked', (event: ChirpLikedEvent) => {
//     //     //     if (event.chirpId === initialChirp.id) {
//     //     //         setLikesCount((prev) => prev + 1);
//     //     //     }
//     //     // });

//     //     channel.listen('.ChirpLiked', (event: any) => {
//     //         console.log('Поймали событие ChirpLiked во втором браузере! Данные:', event);
            
//     //         // В некоторых сборках Laravel Reverb/Echo свойство может прийти в разном регистре.
//     //         // Проверим, как именно оно называется (chirpId или chirp_id или id)
//     //         const id = event.chirpId || event.chirp_id || event.id;
            
//     //         if (id === initialChirp.id) {
//     //             setLikesCount((prev) => prev + 1);
//     //         }
//     //     });

//     //     // Слушаем событие снятия лайка
//     //     // channel.listen('.ChirpUnliked', (event: ChirpLikedEvent) => {
//     //     //     if (event.chirpId === initialChirp.id) {
//     //     //         setLikesCount((prev) => prev - 1);
//     //     //     }
//     //     // });

//     //     channel.listen('.ChirpUnliked', (event: any) => {
//     //         console.log('Поймали событие ChirpUnliked во втором браузере! Данные:', event);
//     //         const id = event.chirpId || event.chirp_id || event.id;
            
//     //         if (id === initialChirp.id) {
//     //             setLikesCount((prev) => prev - 1);
//     //         }
//     //     });

//     //     // Функция очистки (вызывается при размонтировании компонента)
//     //     return () => {
//     //         echo.leaveChannel('chirps-activity');
//     //     };
//     // }, [initialChirp.id]);

//     useEffect(() => {
//         // Подключаемся к общему каналу активности один раз
//         const channel = echo.channel('chirps-activity');

//         // Слушаем событие лайка
//         channel.listen('.ChirpLiked', (event: any) => {
//             console.log('Поймали событие ChirpLiked во втором браузере! Данные:', event);
//             const incomingId = Number(event.chirpId || event.chirp_id);
//             const currentChirpId = Number(initialChirp.id);

//             // Кнопка реагирует ТОЛЬКО если прилетевший ID совпадает с её собственным
//             if (incomingId === currentChirpId) {
//                 setLikesCount((prev) => prev + 1);
//             }
//         });

//         // Слушаем событие снятия лайка
//         channel.listen('.ChirpUnliked', (event: any) => {
//             const incomingId = Number(event.chirpId || event.chirp_id);
//             const currentChirpId = Number(initialChirp.id);

//             if (incomingId === currentChirpId) {
//                 setLikesCount((prev) => prev - 1);
//             }
//         });

//         // Функция очистки: отписываемся от прослушивания событий при размонтировании
//         return () => {
//             channel.stopListening('.ChirpLiked');
//             channel.stopListening('.ChirpUnliked');
//         };
//     }, [initialChirp.id]); // Перезапускаем хук только если изменился ID чирпа


//     // const handleLikeToggle = async () => {
//     //     // Оптимистичное обновление интерфейса (меняем состояние в UI до запроса к API)
//     //     const currentlyLiked = isLiked;
//     //     setIsLiked(!currentlyLiked);
//     //     setLikesCount((prev) => currentlyLiked ? prev - 1 : prev + 1);

//     //     try {
//     //         // Отправляем обычный fetch/axios запрос на бэкенд Laravel API
//     //         const endpoint = currentlyLiked 
//     //             ? `/api/chirps/${initialChirp.id}/unlike` 
//     //             : `/api/chirps/${initialChirp.id}/like`;

//     //         const response = await fetch(endpoint, {
//     //             method: 'POST',
//     //             headers: {
//     //                 'Content-Type': 'application/json',
//     //                 'Accept': 'application/json',
//     //                 // Чтобы работал метод ->toOthers() на бэкенде, 
//     //                 // React ДОЛЖЕН вручную передать ID сокета в заголовках!
//     //                 'X-Socket-ID': echo.socketId() || '', 
//     //             },
//     //         });

//     //         if (!response.ok) throw new Error('API Error');
//     //     } catch (error) {
//     //         // Если сервер вернул ошибку — откатываем UI назад
//     //         setIsLiked(currentlyLiked);
//     //         setLikesCount((prev) => currentlyLiked ? prev + 1 : prev - 1);
//     //         console.error('Не удалось сохранить лайк:', error);
//     //     }
//     // };

//     // Вспомогательная функция для чтения куки в React
//     const getCookie = (name: string): string => {
//         const value = `; ${document.cookie}`;
//         const parts = value.split(`; ${name}=`);
//         if (parts.length === 2) return decodeURIComponent(parts.pop()?.split(';').shift() || '');
//         return '';
//     };

//     const handleLikeToggle = async () => {
//         const currentlyLiked = isLiked;
//         setIsLiked(!currentlyLiked);
//         setLikesCount((prev) => currentlyLiked ? prev - 1 : prev + 1);

//         try {
//             const endpoint = currentlyLiked 
//                 ? `/api/chirps/${initialChirp.id}/unlike` 
//                 : `/api/chirps/${initialChirp.id}/like`;

//             // Получаем CSRF-токен из мета-тегов
//             const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

//             // const response = await fetch(endpoint, {
//             //     method: 'POST',
//             //     headers: {
//             //         'Content-Type': 'application/json',
//             //         'Accept': 'application/json',
//             //         'X-CSRF-TOKEN': token || '', // Защита Laravel от CSRF
//             //         'X-Socket-ID': echo.socketId() || '', 
//             //     },
//             //     credentials: 'include', // КРИТИЧЕСКИ ВАЖНО: передает сессионные куки в API
//             // });

//             // Внутри функции handleLikeToggle:
//             const xsrfToken = getCookie('XSRF-TOKEN');

//             const response = await fetch(endpoint, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'Accept': 'application/json',
//                     'X-XSRF-TOKEN': xsrfToken, // Sanctum ищет именно этот заголовок для куки-авторизации
//                     'X-Socket-ID': echo.socketId() || '', 
//                 },
//                 credentials: 'include',
//             });

//             if (!response.ok) throw new Error('API Error');
//         } catch (error) {
//             // Откат интерфейса при ошибке
//             setIsLiked(currentlyLiked);
//             setLikesCount((prev) => currentlyLiked ? prev + 1 : prev - 1);
//             console.error('Не удалось сохранить лайк:', error);
//         }
//     };


//     return (
//         <div className="flex items-center gap-2">
//             <button onClick={handleLikeToggle} className="text-xl">
//                 {isLiked ? '❤️' : '🤍'}
//             </button>
//             <span className="text-sm text-gray-600">{likesCount}</span>
//         </div>
//     );
// };

import React, { useState, useEffect, useRef } from 'react';
import { echo } from '../utils/echo';

interface Chirp {
    id: number;
    likes_count: number;
    is_liked: boolean;
}

interface LikeButtonProps {
    initialChirp: Chirp;
}

export const LikeButton: React.FC<LikeButtonProps> = ({ initialChirp }) => {
    const [likesCount, setLikesCount] = useState<number>(initialChirp.likes_count);
    const [isLiked, setIsLiked] = useState<boolean>(initialChirp.is_liked);

    // Записываем ID чирпа в реф, чтобы уйти от проблемы замыканий в useEffect
    const chirpIdRef = useRef<number>(Number(initialChirp.id));

    // Всегда обновляем реф, если вдруг initialChirp изменился снаружи
    useEffect(() => {
        chirpIdRef.current = Number(initialChirp.id);
    }, [initialChirp.id]);

    useEffect(() => {
        const channel = echo.channel('chirps-activity');

        // Обработчик лайка
        const handleLikedEvent = (event: any) => {
            const incomingId = Number(event.chirpId || event.chirp_id);
            const myId = chirpIdRef.current;

            console.log(`[WebSocket] Кнопка проверяет ID. Мой ID: ${myId}, Прилетел ID: ${incomingId}`);

            if (incomingId === myId) {
                setLikesCount((prev) => prev + 1);
            }
        };

        // Обработчик анлайка
        const handleUnlikedEvent = (event: any) => {
            const incomingId = Number(event.chirpId || event.chirp_id);
            const myId = chirpIdRef.current;

            console.log(`[WebSocket] Кнопка проверяет ID (Анлайк). Мой ID: ${myId}, Прилетел ID: ${incomingId}`);

            if (incomingId === myId) {
                setLikesCount((prev) => prev - 1);
            }
        };

        // Подписываемся на события с точкой
        channel.listen('.ChirpLiked', handleLikedEvent);
        channel.listen('.ChirpUnliked', handleUnlikedEvent);

        // Чистим за собой строго эти два слушателя
        return () => {
            channel.stopListening('.ChirpLiked', handleLikedEvent);
            channel.stopListening('.ChirpUnliked', handleUnlikedEvent);
        };
    }, []); // Массив зависимостей пустой: слушатель вешается ровно ОДИН раз при старте страницы

    
    // 1. Добавляем React.MouseEvent в аргументы функции
        const handleLikeToggle = async (e: React.MouseEvent<HTMLButtonElement>) => {
            e.preventDefault();  // КРИТИЧЕСКИ ВАЖНО: блокирует стандартную отправку формы и перезагрузку!
            e.stopPropagation(); // Блокирует всплытие события к родительским элементам
            e.nativeEvent.stopImmediatePropagation(); // БЛОКИРУЕТ СТОРОННИЕ СКРИПТЫ (LIVEWIRE) НА КОРНЕВОМ УРОВНЕ

        const currentlyLiked = isLiked;
        setIsLiked(!currentlyLiked);
        setLikesCount((prev) => currentlyLiked ? prev - 1 : prev + 1);

        try {
            const endpoint = currentlyLiked 
                ? `/api/chirps/${initialChirp.id}/unlike` 
                : `/api/chirps/${initialChirp.id}/like`;

            // Читаем ТОКЕН НАПРЯМУЮ из HTML-верстки, это никогда не упадет
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Получаем куку для авторизации Sanctum
            const getCookie = (name: string): string => {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return decodeURIComponent(parts.pop()?.split(';').shift() || '');
                return '';
            };

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Меняем X-XSRF-TOKEN на стандартный X-CSRF-TOKEN
                    'X-Socket-ID': echo.socketId() || '', 
                },
                credentials: 'include',
            });

            if (response.status === 401) {
            window.location.href = '/login';
            return;}

            if (!response.ok) throw new Error('API Error');
        } catch (error) {
            setIsLiked(currentlyLiked);
            setLikesCount((prev) => currentlyLiked ? prev + 1 : prev - 1);
            console.error('Не удалось сохранить лайк:', error);
        }
    };

    return (
        <div className="flex items-center gap-2">
            <button 
                type="button" // Гарантирует, что браузер не сочтет кнопку за submit формы
                onClick={handleLikeToggle} 
                className="text-xl"
            >
                {isLiked ? '❤️' : '🤍'}
            </button>
            <span className="text-sm text-gray-600">{likesCount}</span>
        </div>
    );
};
