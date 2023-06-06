<?php

use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\CommentsController;

return [
    '/' => [
        'action' => [BlogController::class, 'index'],
        'methods' => ['GET'],
        'auth' => false,
    ],
    '/auth' => [
        'action' => [AuthController::class, 'login'],
        'methods' => ['GET'],
        'auth' => false,
    ],
    '/process-login' => [
        'action' => [AuthController::class, 'processLogin'],
        'methods' => ['POST'],
        'auth' => false,
    ],
    '/logout' => [
        'action' => [AuthController::class, 'logout'],
        'methods' => ['GET'],
        'auth' => true,
    ],
    '/blog/create' => [
        'action' => [BlogController::class, 'createPostForm'],
        'methods' => ['GET'],
        'auth' => true,
    ],
    '/blog/save-post' => [
        'action' => [BlogController::class, 'storePost'],
        'methods' => ['POST'],
        'auth' => true,
    ],
    '/blog/view-post' => [
        'action' => [BlogController::class, 'viewPost'],
        'methods' => ['GET'],
        'auth' => false,
    ],
    '/comment/save' => [
        'action' => [CommentsController::class, 'save'],
        'methods' => ['POST'],
        'auth' => true,
    ],
    '/comment/delete' => [
        'action' => [CommentsController::class, 'delete'],
        'methods' => ['POST'],
        'auth' => true,
    ],
];