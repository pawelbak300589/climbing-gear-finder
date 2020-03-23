<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class GearsService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume gears service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to gear api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.climbing_equipment.base_uri');
        $this->secret = config('services.climbing_equipment.secret');
    }

    /**
     * Obtain the full list of gear from the gear service
     */
    public function obtainGears()
    {
        return $this->performRequest('GET', '/api/gears');
    }

    /**
     * Create Gear
     */
    public function createGear($data)
    {
        return $this->performRequest('POST', '/api/gears', $data);
    }

    /**
     * Get a single gear data
     */
    public function obtainGear($gear)
    {
        return $this->performRequest('GET', "/api/gears/{$gear}");
    }

    /**
     * Edit a single gear data
     */
    public function editGear($data, $gear)
    {
        return $this->performRequest('PUT', "/api/gears/{$gear}", $data);
    }

    /**
     * Delete an Gear
     */
    public function deleteGear($gear)
    {
        return $this->performRequest('DELETE', "/api/gears/{$gear}");
    }
}
