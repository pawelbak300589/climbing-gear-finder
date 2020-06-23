<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BrandMappingsService
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
     * Get Mappings By Brand Id
     * @param $brandId
     * @return string
     */
    public function getMappingsByBrandId($brandId)
    {
        return $this->performRequest('GET', "/api/brands/{$brandId}/mappings");
    }

    /**
     * Create Brand Mapping
     * @param $data
     * @param $brandId
     * @return string
     */
    public function createBrandMapping($data, $brandId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/mappings", $data);
    }

    /**
     * Update Brand Mapping
     * @param $data
     * @param $brandId
     * @param $mappingId
     * @return string
     */
    public function updateBrandMapping($data, $brandId, $mappingId)
    {
        return $this->performRequest('PATCH', "/api/brands/{$brandId}/mappings/{$mappingId}", $data);
    }

    /**
     * Delete Brand Mapping
     * @param $brandId
     * @param $mappingId
     * @return string
     */
    public function deleteBrandMapping($brandId, $mappingId)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brandId}/mappings/{$mappingId}");
    }
}
