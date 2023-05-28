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
