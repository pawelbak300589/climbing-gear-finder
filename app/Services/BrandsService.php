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
     * @param $request
     * @return string
     */
    public function obtainBrands($request)
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 25;
        $url = "/api/brands?page={$page}&per_page={$per_page}";

        return $this->performRequest('GET', $url);
    }

    /**
     * Create Brand
     * @param $data
     * @return string
     */
    public function createBrand($data)
    {
        return $this->performRequest('POST', '/api/brands', $data);
    }

    /**
     * Get a single brand data
     * @param $brand
     * @return string
     */
    public function obtainBrand($brand)
    {
        return $this->performRequest('GET', "/api/brands/{$brand}");
    }

    /**
     * Edit a single brand data
     * @param $data
     * @param $brand
     * @return string
     */
    public function updateBrand($data, $brand)
    {
        return $this->performRequest('PATCH', "/api/brands/{$brand}", $data);
    }

    /**
     * Delete an Brand
     * @param $brand
     * @return string
     */
    public function deleteBrand($brand)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brand}");
    }

    /**
     * Blacklist Brand
     * @param $brand
     * @return string
     */
    public function blacklistBrand($brand)
    {
        return $this->performRequest('POST', "/api/brands/{$brand}/blacklist");
    }

    /**
     * Convert Brand to Mapping
     * @param $brand
     * @param $parent
     * @return string
     */
    public function convertBrandToMap($brand, $parent)
    {
        return $this->performRequest('POST', "/api/brands/{$brand}/convert/map/{$parent}");
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

    /**
     * Get Images By Brand Id
     * @param $brandId
     * @return string
     */
    public function getImagesByBrandId($brandId)
    {
        return $this->performRequest('GET', "/api/brands/{$brandId}/images");
    }

    /**
     * Create Brand Image
     * @param $data
     * @param $brandId
     * @return string
     */
    public function createBrandImage($data, $brandId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/images", $data);
    }

    /**
     * Update Brand Image
     * @param $data
     * @param $brandId
     * @param $imageId
     * @return string
     */
    public function updateBrandImage($data, $brandId, $imageId)
    {
        return $this->performRequest('PATCH', "/api/brands/{$brandId}/images/{$imageId}", $data);
    }

    /**
     * Delete Brand Image
     * @param $brandId
     * @param $imageId
     * @return string
     */
    public function deleteBrandImage($brandId, $imageId)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brandId}/images/{$imageId}");
    }

    /**
     * Set image as main brand img
     * @param $brand
     * @return string
     */
    public function setAsMainImage($brandId, $imageId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/images/{$imageId}/main");
    }
}
