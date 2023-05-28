<?php
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\OrderDetailRepository;

class OrderRepository extends BaseRepository
{
    private $orderDetailRepository;
    
    public function __construct(Order $order, OrderDetailRepository $orderDetailRepository)
    {
        parent::__construct($order);
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function processOrder($data, $method = "POST", $id = NULL)
    {
        $order = $method === "POST" ? $this->create($data) : $this->update($id, $data);

        $orderDetail = $method === "POST" ? $this->orderDetailRepository->storeDetail($order->id, $data['detail']): $this->orderDetailRepository->storeDetail($order->id, $data['detail'], "PUT");

        return $order;
    }

    public function all()
    {
        $orders = Order::with(['client', 'details', 'getProducts'])->get();
        return $orders;
    }

    public function find($id)
    {
        return $order = Order::with(['client', 'details', 'getProducts'])->where('id', $id)->first();
    }

    public function confirmOrder($id)
    {
        $orderConfirm = Order::where('id', $id)->update(['confirmed' => 1]);
        return $order = Order::where('id', $id)->first();
    }

    public function rejectOrder($id)
    {
        $orderReject = Order::where('id', $id)->update(['confirmed' => 0]);
        return $order = Order::where('id', $id)->first();
    }

    public function deliverOrder($id)
    {
        $orderDeliver = Order::where('id', $id)->update(['delivered' => 1]);
        return $order = Order::where('id', $id)->first();
    }

}
