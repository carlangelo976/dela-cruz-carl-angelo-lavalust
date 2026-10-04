<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');


/** @var object $router **/

$router->get('/', 'Welcome::index');

$router->get('/users', 'UserController::index');

$router->get('/student/profile', 'StudentController::profile')->middleware('StudentMiddleware');

$router->get('/', function () {
    redirect('login');
});
 
$router->match('/login', 'AuthController::login', ['GET', 'POST']);
$router->match('/register', 'AuthController::register', ['GET', 'POST']); // remove/protect before real production use
$router->get('/logout', 'AuthController::logout');
 

$router->get('/products', 'ProductController::index')
       ->middleware('auth');

$router->get('/api-products', 'ProductController::apiProducts');
 
$router->match('/products/create', 'ProductController::create', ['GET', 'POST'])
       ->middleware('auth');
 
$router->match('/products/edit/{id}', 'ProductController::edit', ['GET', 'POST'])
       ->middleware('auth');
 
$router->get('/products/delete/{id}', 'ProductController::delete')
       ->middleware('auth');


$router->get('create-migration/{migration_class}',
    'MigrationController::create_migration');

$router->get('migrate',
    'MigrationController::migrate');

$router->get('rollback',
    'MigrationController::rollback');

$router->get('rollback-all',
    'MigrationController::rollback_all');

$router->get('refresh',
    'MigrationController::refresh');

$router->get('status',
    'MigrationController::status');


// Product API Routes
$router->get('/api/products', 'ProductController::apiIndex');

$router->post('/api/products', 'ProductController::apiCreate');

$router->put('/api/products/{id}', 'ProductController::apiUpdate');

$router->patch('/api/products/{id}', 'ProductController::apiUpdate');

$router->delete('/api/products/{id}', 'ProductController::apiDelete');