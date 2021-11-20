<?php

namespace App\Repositories\Eloquents;

use App\Models\LogPembelianCustomer;
use App\Repositories\Interfaces\LogPembelianCustomerInterface;

Class LogPembelianCustomerEloquent implements  LogPembelianCustomerInterface {
    private $model;

    public function __construct(LogPembelianCustomer $model) {
        $this->model = $model;
    }

    /*
     * Get All data from Model LogPembelianCustomer
     * */
    public function getAll(){
        return $this->model->all();
    }

    /*
    * Get data by {$id} LogPembelianCustomer from Model LogPembelianCustomer
    * */
    public function getById($id){
        return $this->model->find($id);
    }

    /*
   * Get data by {$customer_id} LogPembelianCustomer from Model LogPembelianCustomer
   * */
    public function getMyLog($customer_id){
        return $this->model->where('customer_id',$customer_id)->get();
    }

    /*
    * Create new data for Model LogPembelianCustomer
    * */
    public function create(array $inputs){
        return $this->model->create($inputs);
    }

    /*
    * Update data by {$id} from Model LogPembelianCustomer
    * */
    public function update(array $inputs, $id){
        $LogPembelianCustomer = $this->model->find($id);
        $LogPembelianCustomer->update($inputs);

        return $LogPembelianCustomer;
    }

    /*
    * Delete data by {$id} from Model LogPembelianCustomer
    * */
    public function delete($id){
        return $this->model->delete($id);
    }
}
