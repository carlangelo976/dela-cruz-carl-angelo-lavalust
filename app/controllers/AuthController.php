<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->library('auth');
    }


    // =====================================================
    // LOGIN
    // =====================================================

    public function login()
    {
        // =============================================
        // REACT / API LOGIN
        // =============================================

        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            // Check username/password
            if ($this->auth->login($username, $password)) {

                // Return JSON for React
                header('Content-Type: application/json');

                echo json_encode([
                    'status' => true,
                    'message' => 'Login successful.',
                    'user' => [
                        'username' => $username
                    ]
                ]);

                return;
            }

            // Invalid login
            header('Content-Type: application/json');

            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid username or password.'
            ]);

            return;
        }


        // =============================================
        // NORMAL LAVALUST WEB LOGIN
        // =============================================

        if ($this->auth->is_logged_in()) {
            redirect('api-products');
        }

        $data = [
            'error' => null
        ];

        $this->call->view(
            'auth/login',
            $data
        );
    }


    // =====================================================
    // REGISTER
    // =====================================================

    public function register()
    {
        $data = [
            'error' => null
        ];

        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($username && $password) {

                $this->auth->register(
                    $username,
                    $password
                );

                redirect('login');
            }

            $data['error'] =
                'Username and password are required.';
        }

        $this->call->view(
            'auth/register',
            $data
        );
    }


    // =====================================================
    // LOGOUT
    // =====================================================

    public function logout()
    {
        $this->auth->logout();

        // If React requests logout, return JSON
        if ($this->io->method() == 'post') {

            header('Content-Type: application/json');

            echo json_encode([
                'status' => true,
                'message' => 'Logout successful.'
            ]);

            return;
        }

        // Normal browser logout
        redirect('login');
    }
}