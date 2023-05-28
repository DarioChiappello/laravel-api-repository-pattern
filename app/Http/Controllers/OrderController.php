<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Traits\ApiResponser;

class OrderController extends Controller
{
    use ApiResponser;

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->all();
        return $this->successResponse($orders);
    }

    public function store(OrderRequest $request)
    {      
        try
        {
            $validateRequest = $this->orderRepository->validateRequest($request);
            $order = $this->orderRepository->processOrder($request->all());
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function show($order)
    {
        $order = $this->orderRepository->find($order);

        return $this->successResponse($order);
    }

    public function update(OrderRequest $request, $order)
    {
        try
        {
            $validateRequest = $this->orderRepository->validateRequest($request);
            $order = $this->orderRepository->processOrder($request->all(), "PUT", $order);
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function destroy($order)
    {
        try
        {
            $order = $this->orderRepository->delete($order);
            return $this->successResponse($order);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        } 
    }

    public function confirm($order)
    {
        return $order = $this->orderRepository->confirmOrder($order);
    }

    public function reject($order)
    {
        return $order = $this->orderRepository->rejectOrder($order);
    }

    public function deliver($order)
    {
        return $order = $this->orderRepository->deliverOrder($order);
    }
}
