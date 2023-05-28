<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Traits\ApiResponser;

class ClientController extends Controller
{
    use ApiResponser;

    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
        $clients = $this->clientRepository->all();
        return $this->successResponse($clients);
    }

    public function store(ClientRequest $request)
    {
        try
        {
            $validateRequest = $this->clientRepository->validateRequest($request);
            $client = $this->clientRepository->create($request->all());
            return $this->successResponse($client);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function show($client)
    {
        $client = $this->clientRepository->find($client);

        return $this->successResponse($client);
    }

    public function update(ClientRequest $request, $client)
    {
        try
        {
            $validateRequest = $this->clientRepository->validateRequest($request);
            $client = $this->clientRepository->update($client, $request->all());
            return $this->successResponse($client);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function destroy($client)
    {
        try
        {
            $client = $this->clientRepository->delete($client);
            return $this->successResponse($client); 
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex, 404);
        }
    }
}
