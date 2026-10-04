<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->model('ProductModel');
        $this->call->library('api');
        $this->call->library('auth');
    }


    // =====================================================
    // NORMAL WEB PAGE - PRODUCTS
    // =====================================================

    public function index()
    {
        $data['products'] = $this->ProductModel->getAll();

        $this->call->view('products/index', $data);
    }


    // =====================================================
    // API PAGE - DISPLAY PRODUCTS
    // GET /api-products
    // =====================================================

    public function apiProducts()
    {
        if (!$this->auth->is_logged_in()) {
            redirect('login');
        }

        $data['products'] = $this->ProductModel->getAll();

        $this->call->view('api-products', $data);
    }


    // =====================================================
    // API - GET ALL PRODUCTS
    // GET /api/products
    // =====================================================

    public function apiIndex()
    {
        $products = $this->ProductModel->getAll();

        return $this->api->respond([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }


    // =====================================================
    // NORMAL WEB PAGE - CREATE PRODUCT
    // =====================================================

    public function create()
    {
        if ($this->io->method() == 'post') {

            $this->ProductModel->create([
                'product_name' => $this->io->post('product_name'),
                'description' => $this->io->post('description'),
                'price' => $this->io->post('price'),
                'quantity' => $this->io->post('quantity'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            redirect('products');
        }

        $this->call->view('products/create');
    }


    // =====================================================
    // NORMAL WEB PAGE - EDIT PRODUCT
    // =====================================================

    public function edit($id)
    {
        $data['product'] = $this->ProductModel->getById($id);

        if ($this->io->method() == 'post') {

            $this->ProductModel->updateProduct($id, [
                'product_name' => $this->io->post('product_name'),
                'description' => $this->io->post('description'),
                'price' => $this->io->post('price'),
                'quantity' => $this->io->post('quantity'),
            ]);

            redirect('products');
        }

        $this->call->view('products/edit', $data);
    }


    // =====================================================
    // NORMAL WEB PAGE - DELETE PRODUCT
    // =====================================================

    public function delete($id)
    {
        $this->ProductModel->deleteProduct($id);

        redirect('products');
    }


    // =====================================================
    // API - CREATE PRODUCT
    // POST /api/products
    // =====================================================

    public function apiCreate()
    {
        $this->api->require_method('POST');

        $data = $this->api->body();


        // Product name validation
        if (empty($data['product_name'])) {

            return $this->api->respond_error(
                'Product name is required',
                422
            );
        }


        // Price validation
        if (!isset($data['price']) || $data['price'] === '') {

            return $this->api->respond_error(
                'Price is required',
                422
            );
        }


        // Quantity validation
        if (!isset($data['quantity']) || $data['quantity'] === '') {

            return $this->api->respond_error(
                'Quantity is required',
                422
            );
        }


        $product = [
            'product_name' => $data['product_name'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'created_at' => date('Y-m-d H:i:s'),
        ];


        $created = $this->ProductModel->create($product);


        if (!$created) {

            return $this->api->respond_error(
                'Failed to create product',
                500
            );
        }


        return $this->api->respond([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }


    // =====================================================
    // API - UPDATE PRODUCT
    // PUT /api/products/{id}
    // =====================================================

    public function apiUpdate($id)
    {
        $this->api->require_method('PUT');


        // Check if product exists
        $existing = $this->ProductModel->getById($id);


        if (!$existing) {

            return $this->api->respond_error(
                'Product not found',
                404
            );
        }


        // Get request body
        $data = $this->api->body();


        // Prepare updated data
        $update = [
            'product_name' => $data['product_name'] ?? $existing->product_name,
            'description' => $data['description'] ?? $existing->description,
            'price' => $data['price'] ?? $existing->price,
            'quantity' => $data['quantity'] ?? $existing->quantity,
        ];


        // Update database
        $updated = $this->ProductModel->updateProduct(
            $id,
            $update
        );


        if (!$updated) {

            return $this->api->respond_error(
                'Failed to update product',
                500
            );
        }


        return $this->api->respond([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => [
                'id' => $id,
                'product_name' => $update['product_name'],
                'description' => $update['description'],
                'price' => $update['price'],
                'quantity' => $update['quantity']
            ]
        ], 200);
    }


    // =====================================================
    // API - DELETE PRODUCT
    // DELETE /api/products/{id}
    // =====================================================

    public function apiDelete($id)
    {
        $this->api->require_method('DELETE');


        // Check if product exists
        $existing = $this->ProductModel->getById($id);


        if (!$existing) {

            return $this->api->respond_error(
                'Product not found',
                404
            );
        }


        // Delete product
        $deleted = $this->ProductModel->deleteProduct($id);


        if (!$deleted) {

            return $this->api->respond_error(
                'Failed to delete product',
                500
            );
        }


        return $this->api->respond([
            'status' => true,
            'message' => 'Product deleted successfully',
            'data' => [
                'id' => $id
            ]
        ], 200);
    }
}