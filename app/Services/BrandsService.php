<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BrandsService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume brands service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to brand api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.climbing_equipment.base_uri');
        $this->secret = config('services.climbing_equipment.secret');
    }

    /**
     * Obtain the full list of brand from the brand service
     */
    public function obtainBrands()
    {
        return $this->performRequest('GET', '/api/brands');
    }

    /**
     * Create Brand
     */
    public function createBrand($data)
    {
        return $this->performRequest('POST', '/api/brands', $data);
    }

    /**
     * Get a single brand data
     */
    public function obtainBrand($brand)
    {
        return $this->performRequest('GET', "/api/brands/{$brand}");
    }

    /**
     * Edit a single brand data
     */
    public function editBrand($data, $brand)
    {
        return $this->performRequest('PUT', "/api/brands/{$brand}", $data);
    }

    /**
     * Delete an Brand
     */
    public function deleteBrand($brand)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brand}");
    }
}
