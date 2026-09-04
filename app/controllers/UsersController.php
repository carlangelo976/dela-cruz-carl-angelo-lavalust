
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->call->model('UsersModel');
    }

    public function index()
    {
        $users = $this->UsersModel->all();

        $this->call->view('users', ['users' => $users]);
    }
    //ang model ang nakuha ng database credential mula sa .env file at ang controller ang nag iinvoke ng model para makuha ang data mula sa database at ipasa ito sa view.
}
