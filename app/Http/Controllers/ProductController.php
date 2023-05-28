<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\ApiResponser;

class ProductController extends Controller
{
    use ApiResponser;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->all();
        return $this->successResponse($products);
    }

    public function store(ProductRequest $request)
    {
        try
        {
            $validateRequest = $this->productRepository->validateRequest($request);
            $product = $this->productRepository->create($request->all());
            return $this->successResponse($product);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
        
    }

    public function show($product)
    {
        $product = $this->productRepository->find($product);

        return $this->successResponse($product);
    }

    public function update(ProductRequest $request, $product)
    {
        try
        {
            $validateRequest = $this->productRepository->validateRequest($request);
            $product = $this->productRepository->update($product, $request->all());
            return $this->successResponse($product);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function destroy($product)
    {
        try
        {
            $product = $this->productRepository->delete($product);
            return $this->successResponse($product); 
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }
}
