<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        // Start PHP session if needed
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check student access
        if (
            isset($_SESSION['student_access']) &&
            $_SESSION['student_access'] === true
        ) {
            // Access allowed
            return $next();
        }

        // Access denied
        redirect(site_url('student'));
        exit();
    }
}