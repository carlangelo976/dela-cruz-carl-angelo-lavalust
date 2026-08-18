<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        // Start PHP session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // For this activity, visiting the student home
        // gives the user permission to access the profile.
        $_SESSION['student_access'] = true;

        $this->call->view('student_home');
    }

    public function profile()
    {
        $student = [
            'student_id' => 'MCC2023-01391',
            'name'       => 'NIÑO ALLEN B. ATIENZA',
            'course'     => 'BS Information Technology',
            'year'       => '3RD Year',
            'section'    => '3 F2',
            'email'      => 'atienzaninoallen0109@gmail.com'
        ];

        $this->call->view('student_profile', $student);
    }
}