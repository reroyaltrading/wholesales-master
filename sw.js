var CACHE_NAME = 'my-site-cache-v3';
var urlsToCache = [
  'public/js/jquery-2.0.0.min.js',
  'public/js/bootstrap.bundle.min.js',
  'public/css/bootstrap.css',
  'public/fonts/fontawesome/css/fontawesome-all.min.css',
  'public/plugins/fancybox/fancybox.min.js',
  'public/plugins/fancybox/fancybox.min.css',
  'public/plugins/owlcarousel/assets/owl.carousel.min.css',
  'public/plugins/owlcarousel/assets/owl.theme.default.css',
  'public/plugins/owlcarousel/owl.carousel.min.js   ',
  'public/css/ui.css',
  'public/css/responsive.css',
  'public/js/script.js',
  'public/js/bootstrap-notify.min.js',
  'public/js/pace.min.js',
  'public/plugins/dropzone/dropzone.js',
  'favicon.png',
  'logo.png',
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request)
        .then(function(response) {
          // Cache hit - return response
          if (response) {
            return response;
          }
          return fetch(event.request);
        }
      )
    );
  });


  self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request)
        .then(function(response) {
          // Cache hit - return response
          if (response) {
            return response;
          }
  
          // IMPORTANT: Clone the request. A request is a stream and
          // can only be consumed once. Since we are consuming this
          // once by cache and once by the browser for fetch, we need
          // to clone the response.
          var fetchRequest = event.request.clone();
  
          return fetch(fetchRequest).then(
            function(response) {
              // Check if we received a valid response
              if(!response || response.status !== 200 || response.type !== 'basic') {
                return response;
              }
  
              // IMPORTANT: Clone the response. A response is a stream
              // and because we want the browser to consume the response
              // as well as the cache consuming the response, we need
              // to clone it so we have two streams.
              var responseToCache = response.clone();
  
              caches.open(CACHE_NAME)
                .then(function(cache) {
                  cache.put(event.request, responseToCache);
                });
  
              return response;
            }
          );
        })
      );
  });