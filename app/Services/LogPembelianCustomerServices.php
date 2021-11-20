<?php

namespace App\Services;
use App\Models\AdminFee;
use App\Repositories\Interfaces\LogPembelianCustomerInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class LogPembelianCustomerServices {
    private $logCusRepository;
    private $productRepository;

    public function __construct(
        LogPembelianCustomerInterface $logCusRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->logCusRepository = $logCusRepository;
        $this->productRepository = $productRepository;
    }

    public function getAll(){
        return $this->logCusRepository->getAll();
    }

    public function getMyLog($customer_id) {
        return $this->logCusRepository->getMyLog($customer_id);
    }

    public function getById($id) {
        return $this->logCusRepository->getById($id);
    }

    public function create(array $inputs) {
        $product = $this->productRepository->findHasOneFee($inputs['product_id']);
        $total_price = (int) $product->price + (int) $product->admin_fee['fee'];
        $deposit_before = (int) $product->deposit;
        $deposit_after = (int) $product->deposit - (int) $product->price;

        $input['total_price'] = $total_price;
        $input['product_id'] = $product->admin_fee['id'];
        $input['admin_fee_id'] = $product->id;
        $input['deposit_before'] = $deposit_before;
        $input['deposit_after'] = $deposit_after;
        $input['customer_id'] = \Auth::user()->id;


        if($success = $this->logCusRepository->create($input) ) {
            $data_product = $this->productRepository->getById($product->id);
            $data_product['deposit'] = $deposit_after;
            $data_product->save();
        }
        return $success;
    }

    public function update(array $inputs,$id) {
        $product = $this->getById($id);
        $product['title'] = $inputs['title'];
        $product['category'] = $inputs['category'];
        $product['deposit'] = $inputs['deposit'];
        $product['price'] = $inputs['price'];

        return $product->save();
    }

    public function destroy($id){
        return $this->logCusRepository->delete($id);
    }
}
