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
    // NORMAL LOGIN
    // GET  /login
    // POST /login
    // =====================================================

    public function login()
    {
        // Kapag naka-login na, diretso sa API Products page
        if ($this->auth->is_logged_in()) {
            redirect('api-products');
        }

        $data = [
            'error' => null
        ];

        // Normal LavaLust login form
        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {

                redirect('api-products');
            }

            $data['error'] = 'Invalid username or password.';
        }

        // Display normal HTML login page
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
        // api->body() reads JSON as well as form encoded input. io->post()
        // only reads $_POST, which is empty for a JSON login request.
        $data = $this->api->body();

        $username = $data['username'] ?? NULL;
        $password = $data['password'] ?? NULL;

        // Validate username and password
        if (!$username || !$password) {

            return $this->api->respond_error(
                'Username and password are required',
                422
            );
        }

        // Authenticate user
        if ($this->auth->login($username, $password)) {

            return $this->api->respond([
                'status' => true,
                'message' => 'Login successful',
                'user' => [
                    'username' => $username
                ]
            ], 200);
        }

        // Invalid credentials
        return $this->api->respond_error(
            'Invalid username or password',
            401
        );
    }


    // =====================================================
    // REGISTER
    // GET  /register
    // POST /register
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
    // GET  /logout
    // POST /logout
    // =====================================================

    public function logout()
    {
        $this->auth->logout();

        // React/API logout
        if ($this->io->method() == 'post') {

            return $this->api->respond([
                'status' => true,
                'message' => 'Logout successful.'
            ], 200);
        }

        // Normal browser logout
        redirect('login');
    }
}