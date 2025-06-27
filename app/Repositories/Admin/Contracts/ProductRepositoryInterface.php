<?php

namespace App\Repositories\Admin\Contracts;
use App\Models\Product;

interface ProductRepositoryInterface {
    public function all();
    public function createProduct(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
