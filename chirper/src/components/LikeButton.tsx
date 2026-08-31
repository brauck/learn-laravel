import React, { useState, useEffect } from 'react';
import { echo } from '../utils/echo';

// Описываем интерфейс пропсов чирпа
interface Chirp {
    id: number;
    likes_count: number;
    is_liked: boolean;
}

interface LikeButtonProps {
    initialChirp: Chirp;
}

// Описываем структуру данных, которая прилетит по WebSocket
interface ChirpLikedEvent {
    chirpId: number;
}

export const LikeButton: React.FC<LikeButtonProps> = ({ initialChirp }) => {
    const [likesCount, setLikesCount] = useState<number>(initialChirp.likes_count);
    const [isLiked, setIsLiked] = useState<boolean>(initialChirp.is_liked);

    useEffect(() => {
        // Подключаемся к публичному каналу Reverb
        const channel = echo.channel('chirps-activity');

        // Слушаем событие лайка
        channel.listen('ChirpLiked', (event: ChirpLikedEvent) => {
            if (event.chirpId === initialChirp.id) {
                setLikesCount((prev) => prev + 1);
            }
        });

        // Слушаем событие снятия лайка
        channel.listen('ChirpUnliked', (event: ChirpLikedEvent) => {
            if (event.chirpId === initialChirp.id) {
                setLikesCount((prev) => prev - 1);
            }
        });

        // Функция очистки (вызывается при размонтировании компонента)
        return () => {
            echo.leaveChannel('chirps-activity');
        };
    }, [initialChirp.id]);

    const handleLikeToggle = async () => {
        // Оптимистичное обновление интерфейса (меняем состояние в UI до запроса к API)
        const currentlyLiked = isLiked;
        setIsLiked(!currentlyLiked);
        setLikesCount((prev) => currentlyLiked ? prev - 1 : prev + 1);

        try {
            // Отправляем обычный fetch/axios запрос на бэкенд Laravel API
            const endpoint = currentlyLiked 
                ? `/api/chirps/${initialChirp.id}/unlike` 
                : `/api/chirps/${initialChirp.id}/like`;

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // Чтобы работал метод ->toOthers() на бэкенде, 
                    // React ДОЛЖЕН вручную передать ID сокета в заголовках!
                    'X-Socket-ID': echo.socketId() || '', 
                },
            });

            if (!response.ok) throw new Error('API Error');
        } catch (error) {
            // Если сервер вернул ошибку — откатываем UI назад
            setIsLiked(currentlyLiked);
            setLikesCount((prev) => currentlyLiked ? prev + 1 : prev - 1);
            console.error('Не удалось сохранить лайк:', error);
        }
    };

    return (
        <div className="flex items-center gap-2">
            <button onClick={handleLikeToggle} className="text-xl">
                {isLiked ? '❤️' : '🤍'}
            </button>
            <span className="text-sm text-gray-600">{likesCount}</span>
        </div>
    );
};
