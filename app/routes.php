<?php


use App\Controllers\TasksController;
use App\Controllers\AuthController;

return [
    '/' => TasksController::class . '@index',
    '/task/create' => TasksController::class . '@create',
    '/task/edit' => TasksController::class . '@edit',
    '/login' => AuthController::class . '@login',
    '/logout' => AuthController::class . '@logout',
];
