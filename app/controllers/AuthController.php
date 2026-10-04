<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->library('auth');
        $this->call->library('api');
    }


    // =====================================================
    // NORMAL LOGIN + API LOGIN
    // GET  /login
    // POST /login
    // =====================================================

    public function login()
    {
        // =============================================
        // API / REACT LOGIN
        // =============================================

        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if (!$username || !$password) {

                return $this->api->respond_error(
                    'Username and password are required',
                    422
                );
            }

            if ($this->auth->login($username, $password)) {

                return $this->api->respond([
                    'status' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'username' => $username
                    ]
                ], 200);
            }

            return $this->api->respond_error(
                'Invalid username or password',
                401
            );
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
    // API LOGIN
    // POST /api/login
    // =====================================================

    public function apiLogin()
    {
        $username = $this->io->post('username');
        $password = $this->io->post('password');

        if (!$username || !$password) {

            return $this->api->respond_error(
                'Username and password are required',
                422
            );
        }

        if ($this->auth->login($username, $password)) {

            return $this->api->respond([
                'status' => true,
                'message' => 'Login successful',
                'user' => [
                    'username' => $username
                ]
            ], 200);
        }

        return $this->api->respond_error(
            'Invalid username or password',
            401
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

        if ($this->io->method() == 'post') {

            return $this->api->respond([
                'status' => true,
                'message' => 'Logout successful.'
            ], 200);
        }

        redirect('login');
    }
}