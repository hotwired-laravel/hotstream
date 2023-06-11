<?php

use Tonysm\ImportmapLaravel\Facades\Importmap;

Importmap::pinAllFrom('resources/js', to: 'js/', preload: true);

Importmap::pin('@hotwired/turbo', to: 'https://ga.jspm.io/npm:@hotwired/turbo@7.3.0/dist/turbo.es2017-esm.js');
Importmap::pin('laravel-echo', to: 'https://ga.jspm.io/npm:laravel-echo@1.15.1/dist/echo.js');
Importmap::pin('pusher-js', to: 'https://ga.jspm.io/npm:pusher-js@8.0.2/dist/web/pusher.js');
Importmap::pin('axios', to: 'https://ga.jspm.io/npm:axios@0.27.2/index.js');
Importmap::pin('#lib/adapters/http.js', to: 'https://ga.jspm.io/npm:axios@0.27.2/lib/adapters/xhr.js');
Importmap::pin('#lib/defaults/env/FormData.js', to: 'https://ga.jspm.io/npm:axios@0.27.2/lib/helpers/null.js');
Importmap::pin('buffer', to: 'https://ga.jspm.io/npm:@jspm/core@2.0.1/nodelibs/browser/buffer.js');
Importmap::pin('@hotwired/stimulus', to: 'https://ga.jspm.io/npm:@hotwired/stimulus@3.2.1/dist/stimulus.js');
Importmap::pin('@hotwired/stimulus-loading', to: 'vendor/stimulus-laravel/stimulus-loading.js', preload: true);
Importmap::pin('el-transition', to: 'https://ga.jspm.io/npm:el-transition@0.0.7/index.js');
