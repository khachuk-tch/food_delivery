

const CACHE_NAME = 'khachuk-food-v2';
const urlsToCache = [
  '/food_delivery/public/',
  '/food_delivery/public/index.php',
  '/food_delivery/public/offline.html',
  '/food_delivery/public/assets/css/style.css',
  '/food_delivery/public/assets/js/script.js',
  '/food_delivery/icons/icon-192x192.png',
  '/food_delivery/icons/icon-512x512.png'
];

// Install and cache core files
self.addEventListener('install', event => {
  console.log('[SW] Installing...');
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
  );
});

// Activate and clean old caches
self.addEventListener('activate', event => {
  console.log('[SW] Activated');
  event.waitUntil(
    caches.keys().then(names => {
      return Promise.all(
        names.map(name => {
          if (name !== CACHE_NAME) return caches.delete(name);
        })
      );
    })
  );
});

// Fetch — use cache first, fallback to network, then offline.html
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return (
        response ||
        fetch(event.request).catch(() => caches.match('/food_delivery/public/offline.html'))
      );
    })
  );
});

