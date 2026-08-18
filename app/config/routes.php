<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
*/

/** @var object $router **/

$router->get('/', 'Welcome::index');

$router->get('/student', 'StudentController::index');

$router->get('/student/profile', 'StudentController::profile')->middleware('StudentMiddleware');