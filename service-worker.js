const CACHE_STATIC = 'static-v1';

// Installation : Mise en cache des fichiers statiques uniquement
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_STATIC).then(cache => {
            return cache.addAll([
                '/assets/css/app.css',
                '/assets/css/animate.css',
                '/assets/css/foundation.css',
                '/assets/css/foundation.min.css',
                '/assets/js/app.js'
            ]);
        })
    );
});

// Activation : Nettoyage des anciens caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_STATIC)
                    .map(key => caches.delete(key))
            );
        })
    );
});

// Fetch : Différenciation des fichiers statiques et des pages dynamiques
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // 📌 Stratégie Cache-First pour les fichiers statiques
    if (url.origin === location.origin && (url.pathname.startsWith('/assets/') || url.pathname.endsWith('.js') || url.pathname.endsWith('.css'))) {
        event.respondWith(
            caches.match(event.request).then(cached => {
                return cached || fetch(event.request);
            })
        );
        return;
    }

    // 🚨 IMPORTANT : Toujours récupérer les pages HTML depuis le serveur
    if (event.request.mode === 'navigate') {
        event.respondWith(fetch(event.request));
        return;
    }

    // 📌 Fallback pour tout le reste : Network-first
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});
