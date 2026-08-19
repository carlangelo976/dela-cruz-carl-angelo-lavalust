<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');


/** @var object $router **/

$router->get('/', 'Welcome::index');

$router->get('/student', 'StudentController::index');

$router->get('/student/profile', 'StudentController::profile')->middleware('StudentMiddleware');