<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once __DIR__ . '/../middlewares/StudentMiddleware.php';

$config['middlewares'] = [
    'StudentMiddleware' => new StudentMiddleware(),
];