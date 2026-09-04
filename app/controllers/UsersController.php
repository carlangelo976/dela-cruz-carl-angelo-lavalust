```php
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    protected $UsersModel;

    public function __construct()
    {
        parent::__construct();

        $this->UsersModel = new UsersModel();
    }

    public function index()
    {
        $users = $this->UsersModel->all();

        // Use $users here for the next part of the activity
    }
}
