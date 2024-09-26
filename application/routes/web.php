<?php

// Đăng ký các route cho phần web
$routes->get('/', 'HomeController::index');
$routes->get('product/(:num)/(:string)', 'ProductController::show:$1:$2');
$routes->post('product/create', 'ProductController::create');
$routes->put('product/update/(:num)', 'ProductController::update/$1');
$routes->delete('product/delete/(:num)', 'ProductController::delete/$1');

$routes->get('admin/index/', 'AdminController::index');
$routes->get('admin/(:any)/(:any)', 'AdminController::$1:$2');

$routes->get('admin/(:any)', 'AdminController::$1', [
    \App\Middlewares\AuthMiddleware::class,
    \App\Middlewares\PermissionMiddleware::class
]); //router de khi goi bat ky admin/string nào nó cũng gọi đến Controller -> Action

$routes->post('admin/edit', 'AdminController::edit', [
    \App\Middlewares\AuthMiddleware::class,
    \App\Middlewares\PermissionMiddleware::class
]);

$routes->delete('admin/delete', 'AdminController::delete', [
    \App\Middlewares\AuthMiddleware::class,
    \App\Middlewares\PermissionMiddleware::class
]);



// Đăng ký routes cho API
$routes->get('api/users', 'Api\UsersController::index');
$routes->get('api/users/(:num)', 'Api\UsersController::show:$1');
$routes->get('api/users/(:any)', 'Api\UsersController::$1');
$routes->post('api/users', 'Api\UsersController::store');
$routes->put('api/users/(:num)', 'Api\UsersController::update:$1');
$routes->delete('api/users/(:num)', 'Api\UsersController::delete:$1');
