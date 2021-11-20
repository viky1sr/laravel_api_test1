<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LogPembelianCustomerServices;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class LogPembelianCustomerApiController extends Controller
{
    private $logCusService;
    private $productService;

    public function __construct(
        LogPembelianCustomerServices $logCusService,
        ProductServices $productService
    ){
        $this->logCusService = $logCusService;
        $this->productService = $productService;
    }

    public function getAll(){
        $res = $this->logCusService->getAll();
        return response()->json($res,200);
    }

    public function getMyLog($customer_id){
        if(\Auth::user()->id == $customer_id) {
            $res = $this->logCusService->getMyLog($customer_id);
            return response()->json($res,200);
        } else {
            return response()->json([
                'status' => false,
                'messages' => 'Not your transaction'
            ],422);
        }
    }

    public function getById($id){
        $res = $this->logCusService->getById($id);
        return response()->json($res,200);
    }

    public function create(Request $request) {
        $validated = logPembelianValidation($request->all()); /*Validation with helper*/
        if($validated->fails()) {
            return response()->json([
                'status' => false,
                'messages' => 'Please select product'
            ],422);
        } else {
            $product = $this->productService->getById($request->product_id);
            /* Cek deposit product */
            if($product->deposit >= $product->price) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Deposit tidak mencukupin.'
                ],422);
            } else {
                if($buy = $this->logCusService->create($request->except('_token','submit'))) {
                    $buy->report(); /* Auto update from Model */
                    return response()->json($buy,201);
                }
            }
        }
    }

    public function destroy($id){
        return $this->logCusService->destroy($id);
    }

    public function getRepotrs() {
        $res = \DB::table('report_transaksis')
            ->leftJoin('users','users.id','=','report_transaksis.customer_id')
            ->leftJoin('products','products.id','=','report_transaksis.product_id')
            ->leftJoin('admin_fees','admin_fees.id','=','report_transaksis.admin_fee_id')
            ->leftJoin('log_pembelian_customers','log_pembelian_customers.id','=','report_transaksis.log_pembelian_id')
            ->select(
                'users.name as customer','products.title as productName','products.price as productPrice',
                'admin_fees.fee as adminFee','log_pembelian_customers.total_price as totalPrice','log_pembelian_customers.deposit_after as deposit'
            )
            ->get();

        return response()->json($res,200);
    }
}
