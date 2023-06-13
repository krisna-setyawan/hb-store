<?php

namespace App\Controllers\Sales;

use App\Models\Sales\PenjualanOrderModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Order extends ResourcePresenter
{
    protected $helpers = ['form'];

    public function index()
    {
        $modelOrder = new PenjualanOrderModel();
        $order = $modelOrder->where('status', 'Waiting')->findAll();

        $data = [
            'order' => $order
        ];

        return view('sales/order/index', $data);
    }
}
