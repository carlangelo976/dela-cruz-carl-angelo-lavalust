<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
    }

    
    public function index()
    {
        $data['products'] = $this->ProductModel->getAll();
        $this->call->view('products/index', $data);
    }

    
    public function create()
    {
        if ($this->io->method() == 'post') {
            $this->ProductModel->create([
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
            redirect('products');
        }

        $this->call->view('products/create');
    }

   
    public function edit($id)
    {
        $data['product'] = $this->ProductModel->getById($id);

        if ($this->io->method() == 'post') {
            $this->ProductModel->updateProduct($id, [
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity'),
            ]);
            redirect('products');
        }

        $this->call->view('products/edit', $data);
    }

    
    public function delete($id)
    {
        $this->ProductModel->deleteProduct($id);
        redirect('products');
    }
}