<?php
<<<<<<< HEAD

=======
>>>>>>> 19869cebd9a3aec802fd490c74483fc615d3b47b
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
<<<<<<< HEAD
    public function handle($next)
    {
        // Start PHP session if it has not started yet
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the student has access
        if (
            isset($_SESSION['student_access']) &&
            $_SESSION['student_access'] === true
        ) {
            // Access allowed — continue to the controller
            return $next();
        }

        // Access denied — send user back to student home
        redirect(site_url('student'));
        exit();
=======
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['student_access']) && $_SESSION['student_access'] === true) {
            return true;
        } else {
            redirect('student');
            exit();
        }
>>>>>>> 19869cebd9a3aec802fd490c74483fc615d3b47b
    }
}