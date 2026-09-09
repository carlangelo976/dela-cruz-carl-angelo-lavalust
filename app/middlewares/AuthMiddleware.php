<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    /**
     * Blocks unauthenticated users from reaching the wrapped route.
     * Runs before ProductController on every /products* route.
     */
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('session');

        if (!$lava->session->userdata('logged_in')) {
            redirect('login');
        }

        return $next();
    }
}