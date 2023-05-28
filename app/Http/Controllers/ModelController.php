<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Repositories\ModelRepository;

class ModelController extends Controller
{
    use ApiResponser;

    protected $modelRepository;

    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    public function index(Request $request, $model)
    {
        $data = $this->modelRepository->all($model);

        return $this->successResponse($data);
    }

    public function show(Request $request, $model, $id)
    {
        $data = $this->modelRepository->find($model, $id);

        return $this->successResponse($data);
    }
}
