<?php

use AssetCompress\Middleware\AssetCompressMiddleware;
use Cake\Routing\DispatcherFactory;
use Cake\Core\Configure;
use Cake\Event\EventManager;

$appClass = Configure::read('App.namespace') . '\Application';
if (class_exists($appClass)) {
    // Bind the middleware class after the error handler, or at the end
    // of the queue. We want to be after the error handler so 404's render nicely.
    EventManager::instance()->on('Server.buildMiddleware', function ($queue) {
        $middleware = new AssetCompressMiddleware();
        $queue->insertAfter('Cake\Error\Middleware\ErrorHandlerMiddleware', $middleware);
    });
} else {
    DispatcherFactory::add('AssetCompress.AssetCompressor');
}
