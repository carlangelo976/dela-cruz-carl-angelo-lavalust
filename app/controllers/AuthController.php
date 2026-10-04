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
        // Kapag naka-login na, diretso sa API Products page
        if ($this->auth->is_logged_in()) {
            redirect('api-products');
        }

        $data = [
            'error' => null
        ];

        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {

                // AFTER LOGIN → API PRODUCTS PAGE
                redirect('api-products');
            }

            $data['error'] = 'Invalid username or password.';
        }

        $this->call->view('auth/login', $data);
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

            $data['error'] = 'Username and password are required.';
        }

        $this->call->view('auth/register', $data);
    }


    // =====================================================
    // LOGOUT
    // =====================================================

    public function logout()
    {
        $this->auth->logout();

        redirect('login');
    }
}