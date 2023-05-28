# API Laravel - Repository Pattern

### Darío Chiappello 

Example API of Repository Pattern 

This app uses a BaseRepository and there are other repositories that inherit the BaseRepository functions

```php
<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        $model->delete();
    }

    public function validateRequest($request)
    {        
        if($request->validate($request->rules()))
        {
            return true;
        }
        
        return false;      
    }

    public function insert($data)
    {
        return $this->model->insert($data);
    }

    public function upsert($data, $args, $fields)
    {
        return $this->model->upsert($data, $args, $fields);
    }
}


```

```php
<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

}

```

Every repository is used in every controller in this way

```php

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

```

The API uses a Trait for return a JSON response

```php
<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response.
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build error response.
     * @param string|array $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

}
```