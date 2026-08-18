<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        session_start();
        $_SESSION['student_access'] = true;
        $this->call->view('student_home');
    }

    public function profile()
    {
        require_once __DIR__ . '/../middlewares/StudentMiddleware.php';

        $middleware = new StudentMiddleware();
        $middleware->handle();

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