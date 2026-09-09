<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('auth');
    }

    public function login()
    {
        if ($this->auth->is_logged_in()) {
            redirect('products');
        }

        $data = ['error' => null];

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                redirect('products');
            }

            $data['error'] = 'Invalid username or password.';
        }

        $this->call->view('auth/login', $data);
    }

    
    public function register()
    {
        $data = ['error' => null];

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($username && $password) {
                $this->auth->register($username, $password);
                redirect('login');
            }

            $data['error'] = 'Username and password are required.';
        }

        $this->call->view('auth/register', $data);
    }

    public function logout()
    {
        $this->auth->logout();
        redirect('login');
    }
}