<?php

namespace App\Repositories\Interfaces;

interface LogPembelianCustomerInterface {
    public function getAll();
    public function getById($id);
    public function create(array $inputs);
    public function update(array $inputs, $id);
    public function delete($id);
    public function getMyLog($customer_id);
}
