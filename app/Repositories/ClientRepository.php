<?php
namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends BaseRepository
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

}
