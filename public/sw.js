const CACHE_NAME = 'aeh-cache-v1';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/offline.html',
  // tambahkan aset CSS/JS statis lainnya di sini
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }
        return fetch(event.request).catch(() => {
          return caches.match('/offline.html');
        });
      })
  );
});
